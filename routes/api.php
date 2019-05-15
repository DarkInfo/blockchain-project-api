<?php

/***** Пользователи *****/

//Получение
Route::get('/users/{id}', 'UserController@get');
//Регистрация
Route::post('/sign-up', 'UserController@signUp');
//Вход
Route::post('/sign-in', 'UserController@signIn');
