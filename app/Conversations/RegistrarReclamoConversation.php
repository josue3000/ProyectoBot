<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage; 
use Illuminate\Support\Carbon;
use App\reclamo;

class RegistrarReclamoConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function confirmarRegistro()
    {
        $user = $this->bot->userStorage()->find();
        $message = '-------------------------------------- <br>';
        $message .= 'Cliente : ' . $user->get('nombre') . '<br>';
        $message .= 'Codigo de servicio : ' . $user->get('codigo') . '<br>';
        $message .= 'Descripción : ' . $user->get('descripcion') . '<br>';
    //    $message .= 'Date : ' . $user->get('date') . '<br>';
    //    $message .= 'Time : ' . $user->get('timeSlot') . '<br>';
        $message .= '---------------------------------------';

        $this->guardar();
        $this->say('su registro de reclamo ha sido guardado exitosamente🙌 <br><br>'.$message);
    }


    public function guardar()
    {
        $user = $this->bot->userStorage()->find();
        $reclamo = new reclamo();
        $reclamo ->cliente = $user -> get ('cliente');
        $reclamo ->id_servicio = $user -> get ('id_servicio');
        $reclamo ->estado = 'Reclamo';
        $reclamo ->descripcion = $user -> get ('descripcion');
        $reclamo ->condicion = '1';
        $mytime = Carbon::now('America/La_Paz');
        $reclamo ->fecha_creacion = $mytime -> toDateTime();
        $reclamo ->fecha_actualizacion = $mytime -> toDateTime();

        $reclamo -> save();
        $message = OutgoingMessage::create('registrado exitosamente 😎');
    }



    public function run()
    {
        $this->confirmarRegistro();
    }
}
