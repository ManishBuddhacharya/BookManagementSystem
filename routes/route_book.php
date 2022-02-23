<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/api/books', 'BookController@getAll');
$router->group(['middleware' => 'api', 'prefix' => 'api/books'], function () use ($router) {
    $router->post('/store', 'BookController@StoreBook');
    $router->post('/update/{book}', 'BookController@updateBook');
    $router->post('/delete/{book}', 'BookController@deleteBook');
    $router->get('/download/{attachment}', 
        ['as' => 'books.attachment', 
        'uses' => 'BookController@downloadBookAttachment'
    ]);
});

