<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Support\Facades\Validator;
// use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\prudevoltsMail;
use BotMan\BotMan\Messages\Outgoing\Question;
use phpDocumentor\Reflection\Types\This;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class SolicitarServicioConversation extends Conversation
{
    public function askDocumento()
    {
        $this ->ask('Introduzca su número de carnet sin extension😉 Porfavor', function(Answer $answer){
            $this->documento = $answer->getText();
            $this->buscaCliente = DB::table('persona as p')
            ->where([
            ['p.num_documento','=',$answer->getText()],
            ['p.tipo_persona','=','Cliente']    
                   ])
            -> select('p.nombre','p.id_persona','p.num_documento','p.telefono','p.direccion','p.email')
            -> first();
            
            if($this->buscaCliente != ''){
                $this->bot->userStorage()->save([
                    'num_documento'=> $answer->getText(),
                    'cliente'=> $this->buscaCliente->id_persona,
                    'nombre'=> $this->buscaCliente->nombre,
                    'direccion'=>$this->buscaCliente->direccion,
                    'telefono'=>$this->buscaCliente->telefono,
                    'email'=>$this->buscaCliente->email

                ]);
                $nombre = $this->buscaCliente-> nombre;
                $cliente = $this->buscaCliente -> id_persona;
                $this->say('Bienvenid@ 😊'.$nombre);
                //$this->askCodigoServicio($nombre, $cliente);
                $this->askProblema1();
            }
            else
            {
                // $this->ask('Es la Primera vez que solicita el servicio?', function (Answer $answer){
                    $this->bot->userStorage()->save([
                        'num_documento'=> $answer->getText()
                    ]);
                // });
                $question = Question::create('Es la primera vez que solicita servicio?')
                          ->fallback('seleccione una opcion')
                          ->callbackId('un razon')
                          ->addButtons([
                            Button::create('SI')-> value('1'),
                            Button::create('NO')-> value('2'),
                                      ]);
                $this-> ask($question, function(Answer $answer){
                if($answer -> isInteractiveMessageReply())
                {
                    if($answer->getValue() === '1')
                    {
                        $this->askName();
                    }
                    else
                    {
                       
                        // return $this-> repeat('Cliente no encontrado, ingresa nuevamente su numero de carnet sin extension o Nit con el que se registro');
                        $this -> say('Cliente no encontrado!, Vuelva a:');
                        $this->askDocumento();
                    }
                }
                });
                
            }
        });






    }


    public function askName()
    {
        $this->ask('Ingresa tus nombres y Apellidos porfavor 👍', function(Answer $answer){
            $validator = Validator::make(['nombre'=> $answer->getText()], [
                    'nombre' => 'regex:/^[\pL\s\-]+$/u',
                ]);
                if($validator -> fails()){
                    return $this -> repeat('ingresa tus nombres y Apellidos de forma correcta');
                }
                $this->bot->userStorage()->save([
                    'nombre' => $answer->getText(),
                ]);
            
                $this->askMovil();
        });
    }

    public function askApellidos()
    {
        $this->ask('Cuales son sus Apellidos?', function (Answer $answer){
            //$this->bot->userStorage()->save([
              //  'telefono'=>$answer->getText(),
           // ]);
                $validator = Validator::make(['apellido'=> $answer->getText()], [
                    'apellido' => 'regex:/^[\pL\s\-]+$/u',
                ]);
                if($validator -> fails()){
                    return $this -> repeat('ingresa tus apellidos de forma correcta');
                }
                $this->bot->userStorage()->save([
                    'apellido' => $answer->getText(),
                ]);

            $this->askMovil();
        });
    }

    public function askMovil(){
        $this->ask('Cual es tu número de Celular? ', function (Answer $answer){
            //$this->bot->userStorage()->save([
              //  'telefono'=>$answer->getText(),
           // ]);
                $validator = Validator::make(['telefono'=> $answer->getText()], [
                    'telefono' => 'min:8|max:8',
                    //'telefono' => 'regex:/^(7|6|2)[0-9]{7}/',
                ]);
                if($validator -> fails()){
                    return $this -> repeat('ingresa porfavor un telefono correcto');
                }
                $this->bot->userStorage()->save([
                    'telefono' => $answer->getText(),
                ]);

            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('Cual es tu Email?', function (Answer $answer) {
            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'email',
            ]);

            if ($validator->fails()) {
                return $this->repeat('Ingresa un email Valido.');
            }
            $codigo = rand(100,999);
            $data = ['codigo'=>$codigo];
            Mail::to($answer->getText())-> send(new prudevoltsMail($data));
            $this->bot->userStorage()->save([
                'email' => $answer->getText(),
                'codigoval'=> $codigo,
            ]);

            
       

        // $this->bot->userStorage()->save([
        //     'codigoval'=> $codigo
        // ]);
            $this->validar();
        });
    }




    public function validar()
    {
        

        $this->ask('ingrese el codigo enviado a su correo para validar su solicitud', function(Answer $answer){
            
            $user = $this->bot->userStorage()->find();

            if($answer->getText() == $user->get('codigoval'))
            {
                $this->say('validado correctamente');
                $this->askDireccion();
            }
            else
            {
                return $this->repeat('Intente nuevamente');
            }

        });
       
        
        // $this -> askDireccion();

    }

    public function askDireccion(){
        $this->ask('cual es la direccion de tu domicilio?', function(Answer $answer){
            $this->bot->userStorage()->save([
                'direccion'=>$answer->getText(),
            ]);
            $this->askProblema();
        });
    }

    public function askProblema(){
        $this->ask('Describa la situacion Problematica?', function(Answer $answer){
            $this->bot->userStorage()->save([
                'descripcion'=>$answer->getText(),
            ]);
            //$this->askLocacion();
            $this->bot->startConversation(new BookingConversation());
        });
    }

    public function askProblema1(){
        $this->ask('Describa la situacion Problematica?', function(Answer $answer){
            $this->bot->userStorage()->save([
                'descripcion'=>$answer->getText(),
            ]);
            //$this->askLocacion();
            $this->bot->startConversation(new Booking1Conversation());
        });
    }


    public function askLocacion(){
        $this->askForLocation('Please tell me your location.', function (Location $location) {
            // $location is a Location object with the latitude / longitude.
            $this->bot->userStorage()->save([
                'latitud'=>$location->getLatitude(),
                'longitud'=>$location->getLongitude(),
            ]);
        });
    }
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:6|confirmed',
    //         'telefono' => 'max:8'
    //     ]);
    // }

    public function run()
    {
        $this->askDocumento();
    }
}
