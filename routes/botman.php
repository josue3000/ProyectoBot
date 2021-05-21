<?php
use App\Http\Controllers\BotManController;
use App\Http\Controllers\Controller;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use Illuminate\Support\Facades\Redirect;


$botman = resolve('botman');

  $botman->hears('.*(hola|buenos días|hey|buenos dias|buenas tardes|buenas noches|holas).*', BotManController::class.'@startConversation');
  

  $botman->hears('.*(reclamo|Queja|obserbacion|obserbación).*',BotmanController::class.'@startReclamo');
  
  // mas opciones para ayudar al cliente.
  
  // $botman->hears('.*tengo un problema|mi refri no congela|mi refrigerador esta fallando |refrigerador|problema|ayuda|necesito asistencia|asistencia.*',BotmanController::class.'@startSolicitud');
  
  
  $botman->hears('.*no congela|enfria|enfría|alimentos|calienta|hecha a perder.*',BotmanController::class.'@startSolicitud1');// problemas de equipos de rfrigeracion, posible falla termostato o motor, o tarjeta 
  $botman->hears('.*chorrea agua|sale agua|escurre agua.*',BotmanController::class.'@startSolicitud2');// posible falla de falta de mantenimiento
  $botman->hears('.*luces rojas|alarma encendida|alarma|error.*',BotmanController::class.'@startSolicitud3'); //posible falla de la tarjeta de control
  $botman->hears('.*se carga de hielo|acumula hielo|aglomera de hielo|mucho hielo.*',BotmanController::class.'@startSolicitud4');// posible falla de resistencias
  $botman->hears('.*pinche una cañeria|corte|cañeria|pinche|perfore|aceite.*',BotmanController::class.'@startSolicitud5');//descuido de limpieza del equipo
  $botman->hears('.*no enciende|no inicia|no reacciona|no hay luces|no prende|no funciona.*',BotmanController::class.'@startSolicitud6');//falla del controlador
  $botman->hears('.*instalacion|instalación|mantenimiento|traslado|aire acondicionado.*',BotmanController::class.'@startSolicitud7');// asistencia para realizar cambios 
  $botman->hears('.*sale agua del aire acondicionado|gotea agua del aire|muestra codigo de error|se bloquea.*',BotmanController::class.'@startSolicitud8');//posibles fallas del equipo en funcion a un diagnostico previo

  
  
  
  //   $bot-> reply('En estos casos es mejor llamar a la asistencia tecnica, para revidar su equipo de refirgeracion');
  //   $bot-> ask('desea realizar una solicitud de servicio?',function (Answer $answer){
  //     ->fallback('no le entendi podria repertilo porfavor')
  //     ->addButtons([
  //       Button::create('Si')->value('1'),
  //       Button::create('No')->value('2'),
  //     ]);
  //   });
  //   // $bot->return redirect()->action('${App\Http\Controllers\BotmanController@startSolicitud}'); 
  //   $bot-> redirect('BotmanController@startSolicitud');
  // });

  $botman->hears('.*que sevicios ofrecen en Prudevolts|servicios|dedican|a que te dedicas|que ofrecen|trabajan.*', function ($bot) {
    $message = 'PRUDEVOLTS se dedica a brindar servicios en los siguiente: <br>';
    $message .= '-------------------------------------- <br>';
    $message .= '✅Brindamos servicios de mantenimineto Correctivo y preventivo en linea Blanca <br>';
    $message .= '✅Instalacion de Equipos de Aire Acondicionado <br>';
    $message .= '✅Proyectos de cámaras frigoríficas<br>';
    $message .= '✅Mantenimientos e instalaciones de Aires Acondicionados de Precision <br>';
   // $message .= '✅ <br>';
   // $message .= '✅ <br>';
    $message .= '---------------------------------------'; 
    $bot-> typesAndWaits(2);
    $bot->reply('Soy SuperVolt, el asistente de Prudevolts, en que puedo ayudarte?'. $message);
  });

   $botman->hears('.*operador|quiero hablar con un operador|agente|quiero hablar con personal|personal|persona.*', function ($bot) {
    $message = '-------------------------------------- <br>';
    $message .= '😉<a href="https://api.whatsapp.com/send?phone=59170626476" target="_blank">Operador✅</a> <br>';
    $message .= '---------------------------------------';
    $bot-> typesAndWaits(2);
    $bot->reply('Click en Operador, será redireccionado con un operador <br><br>'. $message);
   });

   $botman->hears('.*hasta luego |bye|hasta pronto|chau|muy gentil|adios|chaito.*', function ($bot) {
     $bot->reply('Ha sido un gusto poder ayudarte 👌');
    // $bot->randomReply()
    $bot-> typesAndWaits(2);
    $bot->randomReply([
      'hasta pronto,😎',
      'adios 🤗',
      'hasta luego, fue un gusto haberle ayudado 😊'
                      ]);
   });

  $botman->hears('.*gracias|grax.*', function ($bot) {
     //$bot->reply('Es un gusto poder ayudarte');
     $bot-> typesAndWaits(2);
     $bot->randomReply([
      'Es un gusto poder ayudarte😎',
      'es un placer',
      'es mi trabajo 😊'
  ]);
  });

  $botman->hears('.*quien eres|que eres|quien sos|tu eres|tu sos|que haces.*', function ($bot) {
    $bot-> typesAndWaits(2);
    $bot->reply('Soy SuperVolt ✌, el asistente de Prudevolts, en que puedo ayudarte?');
  });


  //$botman->hears('.*donde se encuentran sus oficinas|donde los encuentro|donde estan |cual es su ubicacion|ubicación|como puedo encontrarlos| como los encuentro| donde los puedo localizar|localizan|sucursales|ubicacion|ubicarlos.*', function ($bot) {
  $botman->hears('.*oficinas|donde|estan|ubicacion|ubicación|encontrarlos|encuentro|localizar|localizan|sucursales|ubicacion|ubicarlos|ubicar|encontrar.*', function ($bot) {
    $message = '-------------------------------------- <br>';
    $message .= '📍<a href="https://goo.gl/maps/YnXKKMFZJqmmWE9m7" target="_blank"> click para ir a la ubicacion</a> <br>';
    $message .= '--------------------------------------- <br>';
    $message .= '✅Nos encontramos en la Zona de alto Irpavi Avenida Jorge Muñoz Reyes #18 A <br>';
    $message .= '---------------------------------------';
    $bot-> typesAndWaits(2);
    $bot->reply('porfavor dirijase al siguiente enlace para ver nuestra ubicación en google maps. <br><br>' . $message);
    });


  $botman->fallback(function($bot) {
    $bot-> typesAndWaits(2);
    $bot->reply('no le he entendido, prueba con decirlo de otra manera prueba con (servicios, ubicacion, ).');
    });
 
//  $botman->reply("escribe 'hola' para probar...");

//  $botman->hears('{message}', function($botman, $message) {
  
//             if ($message == 'hola' || $message == 'hey'|| $message == 'hola buenos dias' ) {
//                 //$this->askName($botman);
//                 //$this-> return (BotManController::class.'@startConversation');
//                 //route(BotManController::class.'@startConversation');
//             $botman = BotManController::class.'@startConversation';
//             }else{
//                 $botman->reply("escribe 'hola' para probar...");
//             }
//         });
// $botman->hears('Hi', function ($bot) {
//     $bot->reply('Hello!');
// });
// $botman->hears('Start conversation', BotManController::class.'@startConversation');
