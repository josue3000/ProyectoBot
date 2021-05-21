<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage; 
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Solicitud2;
use App\Persona;

class BookingConversation extends Conversation
{

    public function confirmBooking()
    {
        $user = $this->bot->userStorage()->find();

        $message = '-------------------------------------- <br>';
        $message .= 'Nombre y Apellidos : ' . $user->get('nombre') . '<br>';
        $message .= 'Numero de Documento : ' . $user->get('num_documento') . '<br>';
        $message .= 'Email : ' . $user->get('email') . '<br>';
        $message .= 'telefono : ' . $user->get('telefono') . '<br>';
        $message .= 'Dirección : ' . $user->get('direccion') . '<br>';
        $message .= 'Problema : ' . $user->get('descripcion') . '<br>';
       // $message .= 'Date : ' . $user->get('date') . '<br>';
       // $message .= 'Time : ' . $user->get('timeSlot') . '<br>';
        $message .= '---------------------------------------';

        $this->guardar();

        $this->say('Tu solicitud a sido registrada. aqui se encuentran los detalles. <br><br>' . $message);
        
    }

    public function guardar()
    {$user = $this->bot->userStorage()->find();

    //     $solicitud= new Solicitud();
    //    // $user->nombre = $user->get('nombre') + $user->get('apellido');
    //     $solicitud -> nombre = $user->get('nombre');
    //     $solicitud -> telefono = $user->get('telefono');
    //     $solicitud -> email = $user->get('email');
    //     $solicitud -> direccion = $user->get('direccion');
    //     $solicitud -> problema = $user->get('problema');
    //     $solicitud -> condicion = '1';
    //     $solicitud -> estado = 'Pendiente';
    //     $mytime = Carbon::now('America/La_Paz');
    //     $solicitud -> fecha_creacion = $mytime -> toDateTime();
    //     $solicitud -> fecha_actualizacion = $mytime ->toDateTime();
    //     $solicitud -> save();

        $persona = new Persona;
        $persona ->tipo_persona='Cliente';
        $persona ->nombre = $user -> get ('nombre');
        $persona ->tipo_documento ='Carnet de Identidad';
        $persona ->num_documento = $user -> get ('num_documento');
        $persona ->direccion = $user -> get ('direccion');
        $persona ->telefono = $user -> get ('telefono');
        $persona ->email = $user -> get ('email');
        $persona ->coordenadas = $user -> get ('coordenadas');
        $mytime = Carbon::now('America/La_Paz');
        $persona ->fecha_hora = $mytime -> toDateTime();
        $persona ->save();

        $ultimo = DB::table('persona')
        -> latest('id_persona')
        -> first();

        $solicitud = new Solicitud2();
        $solicitud ->cliente = $ultimo->id_persona;
        $solicitud ->estado = 'Pendiente';
        $solicitud ->descripcion = $user -> get ('descripcion');
        $solicitud ->condicion = '1';
        $mytime = Carbon::now('America/La_Paz');
        $solicitud ->fecha_creacion = $mytime -> toDateTime();
        $solicitud ->fecha_actualizacion = $mytime -> toDateTime();
        $solicitud ->save();

        $message = OutgoingMessage::create('Bye!'); 
        return true; 


        // $this->say('Tu solicitud a sido registrada. aqui se encuentran los detalles. <br><br>');
        // return $this->bot->startConversation(new ExampleConversation());
    }
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->confirmBooking();
    }
}
