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
                Button::create('Registrar una solicitud de servicio π')->value('1'),
                Button::create('Consultar informacion de un servicio π¬')->value('2'),
                Button::create('Nuestros horarios de atenciΓ³n β')->value('3'),
                Button::create('Donde puede encontrarnos π')->value('4'),
                Button::create('Nuestros servicios π§')->value('5'),
                Button::create('Operador π¬ β')->value('6'),
                Button::create('Realizar un Reclamo π')->value('7'),
                        ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === '1') {
                    //$joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                    //$this->say($joke->value->joke);  π¬ππππππβπββπ π§
                    $this->bot->startConversation(new SolicitarServicioConversation());
                } 
                else if($answer->getValue() === '2'){
                         $this->bot->startConversation(new ConsultarServicioConversation());
                         }
                         elseif($answer->getValue() === '3')
                         {
                            $message = '-------------------------------------- <br>';
                            $message .= 'De Lunes a Viernesπ <br>';
                            $message .= '8:00 am - 7:00 pm  <br>';
                            $message .= 'Sabados π  <br>';
                            $message .= '8:00 am - 2:00 pm <br>';
                            
                            $message .= '---------------------------------------';
                            $this->say('Nuestros horarios de atenciΓ³n son las siguientes:  <br><br>' . $message);

                         }
                             elseif($answer->getValue() === '4')
                             {
                                $message = '-------------------------------------- <br>';
                                $message .= 'π<a href="https://goo.gl/maps/YnXKKMFZJqmmWE9m7" target="_blank"> click para ir a la ubicacion</a> <br>';
                                $message .= '--------------------------------------- <br>';
                                $message .= 'βNos encontramos en la Zona de alto Irpavi Avenida Jorge MuΓ±oz Reyes #18 A <br>';
                                $message .= '---------------------------------------';
                                $this->say('porfavor dirijase al siguiente enlace para ver nuestra ubicaciΓ³n en google maps. <br><br>' . $message);
                             }

                    elseif($answer->getValue() === '5'){
                           
                        $message = '-------------------------------------- <br>';
                        $message .= 'βRefrigeraciΓ³n DomΓ©stica <br>';
                        $message .= 'βRefrigeraciΓ³n Comercial <br>';
                        $message .= 'βRefrigeraciΓ³n Industrial <br>';
                        $message .= 'βAutomatizaciΓ³n de maquinaria <br>';
                        $message .= 'βMotores ElΓ©ctricos <br>';
                       // $message .= 'Motores Electricos <br>';
                        $message .= '---------------------------------------';
                        $this->say('Estos son los servicios que ofrecemos a nuestra clientela.π <br><br>' . $message);
                
                    }
                    elseif($answer->getValue() === '6'){
                           
                        $message = '-------------------------------------- <br>';
                        $message .= 'π<a href="https://api.whatsapp.com/send?phone=59170626476" target="_blank">Operadorβ</a> <br>';
                        $message .= '---------------------------------------';
                        $this->say('El siguiente enlace se lo redireccionarΓ‘ al chat del operador. <br><br>' . $message);
                
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
