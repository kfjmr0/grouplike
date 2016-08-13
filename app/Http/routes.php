<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//authentication routes
Route::auth();

// login/register form or usr home if the user's loged in
// modified 2016/7/24. this branching is realized in HomeController
/*
Route::get('/', function () {
    if(Auth::guest()) {
        return view('welcome');
    }
    //return view('home');

});
*/
Route::get('/', 'HomeController@index');
// user home
Route::get('/home', 'HomeController@index');

// show/send messages
Route::get('/message', 'MessageController@index');
Route::get('/message/write', 'MessageController@write');
Route::post('/message', 'MessageController@send');
Route::get('/message/show/{message}', 'MessageController@show');
Route::get('/message/reply/{message}', 'MessageController@reply');
Route::get('/message/sent', 'MessageController@indexOfSentMessage');
Route::get('/message/sent/{message}', 'MessageController@showSentMessage');
Route::delete('/message/destroy/{message}', 'MessageController@destroy');

// schedule management
Route::get('/task/add/{date?}', 'TaskController@add');
Route::post('/task', 'TaskController@store');
Route::get('/task/edit/{task}', 'TaskController@modify');
Route::patch('/task/edit/{task}', 'TaskController@edit');
Route::delete('/task/{task}', 'TaskController@destroy');
Route::get('/task/{date?}', 'TaskController@index');

//Chat
Route::get('/chat', 'ChatController@index');
Route::get('/chat/new', 'ChatController@newTopic');
Route::post('/chat', 'ChatController@makeTopic');
Route::get('/chat/{topic}', 'ChatController@show');
Route::post('/chat/ajax/{topic}', 'ChatController@ajax');
//posted remark is managed by ajax
//Route::post('/chat/{topic}', 'ChatController@post');
