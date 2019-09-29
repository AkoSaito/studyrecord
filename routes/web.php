<?php

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
//RecordsController  勉強記録
Route::get('/', [
    'uses' => 'RecordsController@index',
    'as' => 'records.index'
]);
Route::get('/records/create', 'RecordsController@create');
Route::post('/records', 'RecordsController@store');
Route::post('/records/delete/{id}', 'RecordsController@destroy');

//CategoriesController  カテゴリ
Route::get('/categories/maintenance', 'CategoriesController@maintenance');
Route::get('/categories', 'CategoriesController@create');
Route::post('categories', 'CategoriesController@store');
Route::post('/categories/delete/{id}', 'CategoriesController@destroy');
