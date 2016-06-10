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

/**
 *
 */

Route::get('/', 'PageController@index');
Route::get('about', 'PageController@index');
Route::get('contacts', 'PageController@index');
Route::get('schedule/{page?}', 'PageController@index');
Route::get('archive/{page?}', 'PageController@index');
Route::get('event/{slug}', 'PageController@index');
Route::get('program/{slug}', 'PageController@index');
// Route::group([], function()
// {
    // Route::get('about', 'PageController@about');
    // Route::get('contacts', 'PageController@contacts');
    // Route::get('schedule/{page?}', 'PageController@schedule');
    // Route::get('archive/{page?}', 'PageController@archive');
    // Route::get('event/{slug}', 'PageController@event');
    // Route::get('program/{slug}', 'PageController@program');
// });

/**
 * Admin intrface
 */
Route::group([
    'prefix'     => 'admin',
    'middleware' => ['web', 'auth'],
    'namespace'  => 'Admin',
], function () {

    // Backpack\CinemaCRUD
    CRUD::resource('event', 'EventCrudController');
    CRUD::resource('program', 'ProgramCrudController');
    CRUD::resource('seance', 'SeanceCrudController');

    CRUD::resource('slide', 'SlideCrudController');

    // Backpack\MenuCRUD
    CRUD::resource('menu-item', 'MenuItemCrudController');

    // Backpack\NewsCRUD
    CRUD::resource('article', 'ArticleCrudController');
    CRUD::resource('category', 'CategoryCrudController');
    CRUD::resource('tag', 'TagCrudController');
});
