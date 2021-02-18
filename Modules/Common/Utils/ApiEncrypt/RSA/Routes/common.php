<?php

Route::get('getServerKey', 'API\LogicController@getServerKey');
Route::post('register', 'API\LogicController@register');

Route::post('storeSecret', 'API\LogicController@storeSecret');
Route::get('getSecret', 'API\LogicController@getSecret');
