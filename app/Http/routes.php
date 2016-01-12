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

Route::get('/', ['as' => 'home', 'uses' => 'homeController@index']);
Route::post('updateBiaya', ['as' => 'updateBiaya', 'uses' => 'homeController@updateBiaya']);

Route::post('findPath', [
    'as' => 'findPath',
    'uses' => 'homeController@findPath'
]);

Route::get('{foo}/{p1?}/{p2?}', function($foo,$p1=1, $p2=13){
    ini_set('max_execution_time', 600);
    $startNode = new \app\astar\node((int)$p1, 'startNode');
    $finalNode = new \app\astar\node((int)$p2, 'finalNode');
    ${$foo} = new \app\astar\pathFinder($startNode,$finalNode);
    $res = ${$foo}->findPath();
dd(${$foo},$res);

    return $res;
});

