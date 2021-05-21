<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class ExampleConversation extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create("Hola, es un gusto saludarte, como puedo ayudarte?")
            ->fallback('no estoy entrenado para responder esa pregunta')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Registrar una solicitud de servicio 📋')->value('1'),
                Button::create('Consultar informacion de un servicio 💬')->value('2'),
                Button::create('Nuestros horarios de atención ⌚')->value('3'),
                Button::create('Donde puede encontrarnos 📍')->value('4'),
                Button::create('Nuestros servicios 🔧')->value('5'),
                Button::create('Operador 💬 ☎')->value('6'),
                Button::create('Realizar un Reclamo 📋')->value('7'),
                        ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === '1') {
                    //$joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                    //$this->say($joke->value->joke);  💬🚕🆗📍📌📅📋☎📞⌚⚙🛠🔧
                    $this->bot->startConversation(new SolicitarServicioConversation());
                } 
                else if($answer->getValue() === '2'){
                         $this->bot->startConversation(new ConsultarServicioConversation());
                         }
                         elseif($answer->getValue() === '3')
                         {
                            $message = '-------------------------------------- <br>';
                            $message .= 'De Lunes a Viernes👌 <br>';
                            $message .= '8:00 am - 7:00 pm  <br>';
                            $message .= 'Sabados 😉  <br>';
                            $message .= '8:00 am - 2:00 pm <br>';
                            
                            $message .= '---------------------------------------';
                            $this->say('Nuestros horarios de atención son las siguientes:  <br><br>' . $message);

                         }
                             elseif($answer->getValue() === '4')
                             {
                                $message = '-------------------------------------- <br>';
                                $message .= '📍<a href="https://goo.gl/maps/YnXKKMFZJqmmWE9m7" target="_blank"> click para ir a la ubicacion</a> <br>';
                                $message .= '--------------------------------------- <br>';
                                $message .= '✅Nos encontramos en la Zona de alto Irpavi Avenida Jorge Muñoz Reyes #18 A <br>';
                                $message .= '---------------------------------------';
                                $this->say('porfavor dirijase al siguiente enlace para ver nuestra ubicación en google maps. <br><br>' . $message);
                             }

                    elseif($answer->getValue() === '5'){
                           
                        $message = '-------------------------------------- <br>';
                        $message .= '✅Refrigeración Doméstica <br>';
                        $message .= '✅Refrigeración Comercial <br>';
                        $message .= '✅Refrigeración Industrial <br>';
                        $message .= '✅Automatización de maquinaria <br>';
                        $message .= '✅Motores Eléctricos <br>';
                       // $message .= 'Motores Electricos <br>';
                        $message .= '---------------------------------------';
                        $this->say('Estos son los servicios que ofrecemos a nuestra clientela.👌 <br><br>' . $message);
                
                    }
                    elseif($answer->getValue() === '6'){
                           
                        $message = '-------------------------------------- <br>';
                        $message .= '😉<a href="https://api.whatsapp.com/send?phone=59170626476" target="_blank">Operador✅</a> <br>';
                        $message .= '---------------------------------------';
                        $this->say('El siguiente enlace se lo redireccionará al chat del operador. <br><br>' . $message);
                
                    }
                    elseif($answer->getValue() === '7'){
                           
                        $this->bot->startConversation(new ReclamoConversation());
                
                    }
                         
            }
        });
    }

    /**
     * Start the conversation
     */
    

    public function testBasicTest()
    {
        $this->bot->recibes('hola');
        $this->bot->randomReply([
                    'Hi',
                    'Hello',
                    'Bonjourno'   ]);
    }

    public function run()
    {
        $this->askReason();
    }
}
