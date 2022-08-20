<?php

Route::get('/', 'MainController@index');

Route::get('select-country', ['as' => 'select-country', 'uses' => 'MainController@selectCountry']);

Route::get('select/{country}', 'SelectController@index');

Route::get('map', 'SelectController@map');

Route::get('select/photo/{city}', 'SelectController@photo');

Route::get('photos', 'PhotosController@index');

Route::get('add-photos', ['as' => 'add-photos', 'uses' => 'PhotosController@add']);