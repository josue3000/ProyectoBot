<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\prudevoltsMail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');

// Route::get('contactanos', function(){
//     $codigo = rand(100,999);
//     // $data = rand(300,400);
//     $data = ['codigo'=>$codigo];
//     // $this->say('ingresar el codigo enviado a su correo'.$codigo);
//     Mail::to('josuevallejos40@hotmail.com')->send(new prudevoltsMail($data));
//     return "mensaje enviado";
// });
