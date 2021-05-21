<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;
use App\Conversations\ReclamoConversation;
use App\Conversations\SolicitarServiciosConversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use App\Conversations\OnboardingConversation;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use App\Conversations\SolicitarServicioConversation;
use Illuminate\Support\Facades\Validator;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */ 
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }

    public function startReclamo(BotMan $bot)
    {
        $bot->startConversation(new ReclamoConversation());

    //    $bot->reply('Al parecer necesita asistencia tecnica, le recomendamos por su segurida no intente abrirlos y es mejor desconectarlos hasta que cuente con nuestra asistencia tecnica');
    //    $bot->reply('le gustaria enviar una solicitud para que podamos asistirl@');
    //    $bot->startConversation(new ExampleConversation());
    //     // $question = Question::create("Le gustaria registrar una solicitud para poder asistirl@?")
        //           ->fallback('seleccione una opcion')
        //           ->callbackId('un razon')
        //           ->addButtons([
        //             Button::create('SI')-> value('1'),
        //             Button::create('NO')-> value('2'),
        //                       ]);

        // return $bot->ask($question, function(Answer $answer)
        // {
        //         if($answer -> isInteractiveMessageReply())
        //         {
        //             if($answer ->getValue() === '1')
        //             {
                        
        //             }
        //             else
        //             {
        //                $bot->say ('Le recomiendo que haga una solicitud cuando usted desee');
        //             }
        //         }
        // });
       
    }
    public function startSolicitud1(BotMan $bot)
    {
        $bot-> reply('Son problemas frecuentes en equipos de refrigeración en la que posiblemente hay fallas con el termostato o motocompresor, es recomendable desconectarlo y solcitar soporte técnico');
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
                        // $this->say ('OK $$');
                        $this->bot->startConversation(new SolicitarServicioConversation());
                    }
                else
                    {
                         $this->say ('Le recomiendo que haga una solicitud cuando usted desee');
                    }
                 }
                 
         });
         $bot->startConversation(new SolicitarServicioConversation());
    }
   

    public function startSolicitud2(BotMan $bot)
    {
        $bot-> reply('El problema con la salida de agua por delante de equipo de refrigeracion no es un problema serio, ya que se debe a la falta de mantenimiento del equipo, por lo que se debe limpiar el ducto de desague del equipo, para ubicarlo puede consultar con el manual del mismo o solicitar el servicio');
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
                        // $this->say ('OK $$');
                        $this->bot->startConversation(new SolicitarServicioConversation());
                    }
                else
                    {
                         $this->say ('Le recomiendo que haga una solicitud cuando usted desee');
                    }
                 }
                 
         });
         $bot->startConversation(new SolicitarServicioConversation());
    }


    public function startSolicitud3(BotMan $bot)
    {
        $bot-> reply('Este tipo de problemas con a causa de las tormentas electricas, las cuales averian el sistema electronico del equipo, o incluso afectar directamente al motocompresor por lo que se necesita un diagnóstico técnico, y claramente recomendable que lo desconecte de la alimentacion.');
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
                        // $this->say ('OK $$');
                        $this->bot->startConversation(new SolicitarServicioConversation());
                    }
                else
                    {
                         $this->say ('Le recomiendo que haga una solicitud cuando usted desee');
                    }
                 }
                 
         });
         $bot->startConversation(new SolicitarServicioConversation());
    }



    public function startSolicitud4(BotMan $bot)
    {
        $bot-> reply('El hecho de que un euqipo se cargue de hielo es consecuencia de la falla de algun componente de descongelamiento o de control, por lo que se recomienda desconectarlo y descongelarlo con el uso de agua herbida,es necesario solicitar soporte técnico');
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
                        // $this->say ('OK $$');
                        $this->bot->startConversation(new SolicitarServicioConversation());
                    }
                else
                    {
                         $this->say ('Le recomiendo que haga una solicitud cuando usted desee');
                    }
                 }
                 
         });
         $bot->startConversation(new SolicitarServicioConversation());
    }



    public function startSolicitud5(BotMan $bot)
    {
        $bot-> reply(' huy! esta clase de sucesos son peligrosos, por lo que recomendamos que pueda tapar la perforacion realizada en el equipo con algo que tenga a la mano, como por ejemplo un chicle para evitar que la humedad entre en el sistema de refrigeración y lo mas pronto posible solicitar asistencia técnico');
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
                        // $this->say ('OK $$');
                        $this->bot->startConversation(new SolicitarServicioConversation());
                    }
                else
                    {
                         $this->say ('Le recomiendo que haga una solicitud cuando usted desee');
                    }
                 }
                 
         });
         $bot->startConversation(new SolicitarServicioConversation());
    }


    public function startSolicitud6(BotMan $bot)
    {
        $bot-> reply('Bueno cuando un equipo ya no enciende, se recomienda verificar que el equipo este energizado, asi como también verificar que la toma de corriente este en buenas condiciones conectando una lampara a la toma o cualquier dispositivo que le permita verificar que la toma de corriente este funcionando, en caso de que el equipo aun asi no encienda, es necesario que solicite servicio técnico');
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
                        // $this->say ('OK $$');
                        $this->bot->startConversation(new SolicitarServicioConversation());
                    }
                else
                    {
                         $this->say ('Le recomiendo que haga una solicitud cuando usted desee');
                    }
                 }
                 
         });
         $bot->startConversation(new SolicitarServicioConversation());
    }


    public function startSolicitud7(BotMan $bot)
    {
        $bot-> reply('la situación de que gotee agua del equipo se debe a la captura de humedad por el equipo, por lo que comunmente estos dipositivos deben tener conectado al desagüe, para la solucion de este problema puede usar una maseta o dirigirla fuera de la habitación');
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
                        // $this->say ('OK $$');
                        $this->bot->startConversation(new SolicitarServicioConversation());
                    }
                else
                    {
                         $this->say ('Le recomiendo que haga una solicitud cuando usted desee');
                    }
                 }
                 
         });
         $bot->startConversation(new SolicitarServicioConversation());
    }

    public function startSolicitud8(BotMan $bot)
    {
        $bot-> reply('los códigos de error en base a la marca y modelo de dispositivo informan el fallo del equipo, por lo que es necesario que reciba asistencia técnica, y apagar el equipo, para evitar mas averías');
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
                        // $this->say ('OK $$');
                        $this->bot->startConversation(new SolicitarServicioConversation());
                    }
                else
                    {
                         $this->say ('Le recomiendo que haga una solicitud cuando usted desee');
                    }
                 }
                 
         });
         $bot->startConversation(new SolicitarServicioConversation());
    }
    // public function startConversation3(BotMan $bot)
    // {
    //     $bot->startConversation(new ExampleConversation());
    // }

    // public function startConversation4(BotMan $bot)
    // {
    //     $bot->startConversation(new ExampleConversation());
    // }

    // public function startConversation5(BotMan $bot)
    // {
    //     $bot->startConversation(new ExampleConversation());
    // }

    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:6|confirmed',
    //         'telefono' => 'max:8'
    //     ]);
    // }


}
