<?php

namespace App\Conversations;

use Illuminate\Support\Facades\DB;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;
use phpDocumentor\Reflection\Types\This;

class ReclamoConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function askDocumento()
    {
        $this ->ask('Realmente lamentamos estas situaciones, para Registrar su solictud de Reclamo, porfavor introduzca su numero de carnet sin extension o Nit con el que se registro', function(Answer $answer){
            $this->documento = $answer->getText();
            $this->buscaCliente = DB::table('persona as p')
            ->where([
            ['p.num_documento','=',$answer->getText()],
            ['p.tipo_persona','=','Cliente']    
                   ])
            -> select('p.nombre','p.id_persona','p.num_documento')
            -> first();
            
            if($this->buscaCliente != ''){
                $this->bot->userStorage()->save([
                    'cliente_documento'=> $answer->getText(),
                    'cliente'=> $this->buscaCliente->id_persona,
                    'nombre'=> $this->buscaCliente->nombre,
                ]);
                $nombre = $this->buscaCliente-> nombre;
                $cliente = $this->buscaCliente -> id_persona;
                $this->say('Bienvenido '.$nombre);
                //$this->askCodigoServicio($nombre, $cliente);
                $this->askCodigoServicio();
            }
            else
            {
                return $this-> repeat('Cliente no encontrado, ingresa nuevamente su numero de carnet sin extension o Nit con el que se registro');
            }
            
        });
    }
    public function askCodigoServicio()
    {
        $this ->ask('Para continuar necesito que ingreses el Codigo del Servicio de reclamo',function(Answer $answer){
             $user = $this->bot->userStorage()->find();
             $this->codigo = $answer->getText();
             $existencia = DB::table('venta_servicio')
            ->select('id_venta','codigo')
            ->where('id_cliente','=', $user->get('cliente'))
            ->get();

           // $id_venta = $existencia->id_venta;

            // $contar = 0;
            // if($existencia != '')
            // {
            //     while($contar < count($existencia))
            //     {
            //         if($existencia[$contar]->codigo == $answer->getText())
            //         {
            //             $this->bot->userStorage()->save([
            //                 'codigo'=> $answer->getText(),
            //                 'id_servicio'=> $existencia -> id_venta,
            //             ]);
            //             $this->askDescripcion();
            //         }
            //         else
            //         {
            //             return $this-> repeat('el servicio no fue encontrado, ingresalo nuevamente porfavor');
            //         }
            //         $contar = $contar + 1;
            //     }
            // }
            // else
            // {
            //     return $this-> repeat('el servicio no fue encontrado, ingresalo nuevamente porfavor');
            // }
// ----------------------------------------------otra forma de intentarlo----------------------------

            $contar = 0; 
        
             if(empty($existencia))
             {
                return $this-> repeat('el servicio no fue encontrado, ingresalo nuevamente porfavor');
             }
            else 
             {
                while( $contar < count($existencia))
                {
                    if($existencia[$contar]->codigo == $answer->getText())
                    {
                        $this->bot->userStorage()->save([
                                            'codigo'=> $answer->getText(),
                                            'id_servicio'=> $existencia[$contar] -> id_venta,
                                        ]);
                                        $this->askDescripcion();
                    }
                    else
                    {
                        return $this-> repeat('el servicio no fue encontrado, ingresalo nuevamente porfavor');
                    }
                    $contar = $contar + 1 ; 
                }
             }
            //  return $this-> repeat('el servicio no fue encontrado, ingresalo nuevamente porfavor');
// ---------------------------------------------- PARA PROBAR PARTES DEL CODIGO----------------------------
            // $this->say('el id de usuario es >'.$existencia);
            // $this->askDescripcion();
           
        });
    }

    public function askDescripcion()
    {
        $this->ask('Describa los defectos encontrados porfavor', function(Answer $answer){
            $this->bot->userStorage()->save([
                'descripcion'=>$answer->getText(),
            ]);
            //$this->askLocacion();
            $this->bot->startConversation(new RegistrarReclamoConversation());
        });
    }



    public function run()
    {
        $this->askDocumento();
    }
}
