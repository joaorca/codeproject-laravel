<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('ouath/access_token', function () {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function () {

    Route::resource('client', 'ClientController', [
        'exept' => [
            'create',
            'edit',
        ],
    ]);

    Route::group(['prefix' => 'project'], function () {
        Route::resource('', 'ProjectController', [
            'exept' => [
                'create',
                'edit',
            ],
        ]);

        Route::get('{id}/note', 'ProjectNoteController@index');
        Route::post('{id}/note', 'ProjectNoteController@store');
        Route::get('/id}/note/{noteId}', 'ProjectNoteController@show');
        Route::delete('{id}/note/{noteId}', 'ProjectNoteController@destroy');
        Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
    });

});

