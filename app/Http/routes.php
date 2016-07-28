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


Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin' ]);
Route::post('auth/login', 'Auth\AuthController@postLogin' );

Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout' ]);

Route::get('auth/register', 'Auth\AuthController@getRegister' );
Route::post('auth/register', 'Auth\AuthController@postRegister' );

//password reset routes
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

// categories 

Route::resource('categories','CategoryController', ['except' => ['create']] );

Route::get('blog/{slug}', ['as' => 'blog.single', 'uses' => 'BlogController@getSingle'])->where('slug', '[\w\d\-\_]+');
Route::get('about', 'PagesController@getAbout' );
Route::get('contact','PagesController@getContact');
Route::get('/','PagesController@getIndex');
Route::resource('posts','PostController');
Route::get('blog',['uses' => 'BlogController@getIndex', 'as' => 'blog.index']);

