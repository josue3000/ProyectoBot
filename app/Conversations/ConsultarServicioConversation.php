<?php

namespace App\Conversations;

use Illuminate\Support\Facades\DB;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;
//use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use App\VentaServicio;

class ConsultarServicioConversation extends Conversation
{
    public function askCode()
    {
        $this->ask('Cual es su codigo de Servicio?',function(Answer $answer){
            // $this->bot->userStorage()->save([
            //     'codigo'=> $answer->getText(),
            // ]);

                $this->codigo = $answer->getText();
                //$this->say('Procesando la solicitud: '. $answer->getText());
                $this->buscaServicio = DB::table('venta_servicio as v')
                        ->where([
                                  ['v.codigo','=',$answer->getText()],
                                  ['v.condicion','=','1']
                                ])
                        //->where('v.condicion','=','1')
                        ->select('v.diagnosticoTecnico','v.estado_servicio','v.codigo')
                        //->value('v.diagnosticoTecnico');
                        ->first();
                if($this->buscaServicio != ''){
                    $message = '-------------------------------------- <br>';
                    $message .= 'Codigo : ' . $this->buscaServicio->codigo . '<br>';
                    $message .= 'Estado del servico  : ' . $this->buscaServicio->estado_servicio . '<br>';
                    $message .= 'Diagnostico Tecnico : ' . $this->buscaServicio->diagnosticoTecnico . '<br>';
                   // $message .= 'Problema : ' . $user->get('problema') . '<br>';
                    $message .= '---------------------------------------';
                    $this->say('Grandioso. este es el resultado de tu consulta. <br><br>' . $message);
                 }
                 else
                 {
                     $this->say('Lo siento, no pude encontrar informacion del servicio solicitado');
                 }
                
               // $this->say('El diagnostico es: ' .$this->buscaServicio);



        });
    }


    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askCode();
    }
}
