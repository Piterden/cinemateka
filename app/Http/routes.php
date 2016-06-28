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
 * Vue OPA
 */

Route::get('/', 'PageController@staticPage');
Route::get('about', 'PageController@staticPage');
Route::get('contacts', 'PageController@staticPage');
Route::get('schedule/{page?}', 'PageController@listPage');
Route::get('archive/{page?}', 'PageController@listPage');
Route::get('event/{slug}', 'PageController@entityPage');
Route::get('program/{slug}', 'PageController@entityPage');

/**
 * Admin interface
 */

Route::group([
    'prefix'     => 'admin',
    'middleware' => ['web', 'auth'],
    'namespace'  => 'Admin',
], function ()
{
    // Admin authentication routes
    Route::auth();

    // Other Backpack\Base routes
    Route::get('/', 'AdminController@redirectToDashboard');
    Route::get('dashboard', 'AdminController@dashboard');

    // Backpack\CinemaCRUD
    CRUD::resource('event', 'EventCrudController');
    CRUD::resource('program', 'ProgramCrudController');
    CRUD::resource('place', 'PlaceCrudController');

    CRUD::resource('slide', 'SlideCrudController');

    // Backpack\MenuCRUD
    CRUD::resource('menu-item', 'MenuItemCrudController');

    // Backpack\NewsCRUD
    // CRUD::resource('article', 'ArticleCrudController');
    CRUD::resource('category', 'CategoryCrudController');
    // CRUD::resource('tag', 'TagCrudController');

    /**
     * Загрузка картинок
     */
    Route::post('upload', function ()
    {
        $newName = 'uploads/images/full_'.str_slug(str_random(26)).'.jpg';
        $file    = Input::file('image');
        try {
            $img = Image::make($file)->save($newName);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e], 500);
        }

        return response()->json(['url' => asset($newName)], 200);
    });

});



// Route::group(['middleware' => 'web', 'prefix' => 'admin'], function () {
// });
