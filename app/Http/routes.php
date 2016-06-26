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

Route::get('/', 'PageController@staticPage');
Route::get('about', 'PageController@staticPage');
Route::get('contacts', 'PageController@staticPage');
Route::get('schedule/{page?}', 'PageController@listPage');
Route::get('archive/{page?}', 'PageController@listPage');
Route::get('event/{slug}', 'PageController@entityPage');
Route::get('program/{slug}', 'PageController@entityPage');

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
