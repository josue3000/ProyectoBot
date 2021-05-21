<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage; 
use Illuminate\Support\Carbon;
use App\Solicitud2;


class Booking1Conversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function confirmBooking()
    {
        $user = $this->bot->userStorage()->find();

        $message = '-------------------------------------- <br>';
        $message .= 'Nombre y Apellidos : ' . $user->get('nombre') . '<br>';
       // $message .= 'Apellidos : ' . $user->get('apellido') . '<br>';
        $message .= 'Email : ' . $user->get('email') . '<br>';
        $message .= 'telefono : ' . $user->get('telefono') . '<br>';
        $message .= 'Dirección : ' . $user->get('direccion') . '<br>';
        $message .= 'Problema : ' . $user->get('descripcion') . '<br>';
       // $message .= 'Date : ' . $user->get('date') . '<br>';
       // $message .= 'Time : ' . $user->get('timeSlot') . '<br>';
        $message .= '---------------------------------------';

        $this->guardar();

        $this->say('Tu solicitud a sido registrada. aqui se encuentran los detalles. 👌👌<br><br>' . $message);
        
    }

    public function guardar()
    {$user = $this->bot->userStorage()->find();

        $solicitud= new Solicitud2();
       // $user->nombre = $user->get('nombre') + $user->get('apellido');
        $solicitud -> cliente = $user->get('cliente');
        $solicitud -> descripcion = $user->get('descripcion');
        $solicitud -> condicion = '1';
        $solicitud -> estado = 'Pendiente';
        $mytime = Carbon::now('America/La_Paz');
        $solicitud -> fecha_creacion = $mytime -> toDateTime();
        $solicitud -> fecha_actualizacion = $mytime ->toDateTime();
        $solicitud -> save();

        $message = OutgoingMessage::create('Bye!'); 
        return true; 

        // $this->say('Tu solicitud a sido registrada. aqui se encuentran los detalles. <br><br>');
        // return $this->bot->startConversation(new ExampleConversation());
    }


    public function run()
    {
        $this->confirmBooking();
    }
}
