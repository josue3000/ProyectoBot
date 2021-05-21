<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use App\Conversations\OnboardingConversation;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use App\Conversations\SolicitarServicioConversation;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function startSolicitud(BotMan $bot)
    {
        $question = Question::create("Le gustaria registrar una solicitud para poder asistirl@?")
                  ->fallback('seleccione una opcion')
                  ->callbackId('un razon')
                  ->addButtons([
                    Button::create('SI')-> value('1'),
                    Button::create('NO')-> value('2'),
                              ]);

        return $bot->ask($question, function(Answer $answer)
         {
            if($answer ->isInteractiveMessageReply())
                {
                 if($answer->getValue() === '1')
                    {
                    $this-> startConversation(new SolicitarServicioConversation());
                    // $this ->startSolicitud();
                    }
                else
                    {
                         $this->say ('Le recomiendo que haga una solicitud cuando usted desee');
                    }
                 }
         });
        
    }

}
