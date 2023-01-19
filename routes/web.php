<?php

use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
Route::get('tarefa/exportacao/{extensao}', "App\Http\Controllers\TarefaController@exportacao")->name('tarefa.exportacao');

Auth::routes(['verify' => true]);


Route::resource('tarefa', "App\Http\Controllers\TarefaController");
Route::get('/mensagem-teste', function () {
    // Mail::to('luisferzdeoliveira@gmail.com')->send(new MensagemTesteMail);
    return 'sucesso' ;
});