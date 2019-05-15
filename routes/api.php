<?php

/***** Пользователи *****/

//Получение
Route::get('/users/{id}', 'UserController@get');
//Регистрация
Route::post('/sign-up', 'UserController@signUp');
//Вход
Route::post('/sign-in', 'UserController@signIn');

/***** КОНТАКТЫ *****/

Route::group(['middleware' => 'auth:api'], function(){
    //Создание контакта
    Route::post('/contacts', 'ContactController@create');
    //Обновление контакта
    Route::put('/contacts', 'ContactController@update');
    //Удаление контакта
    Route::delete('/contacts', 'ContactController@delete');
});
//Получение контактов по id пользователя
Route::get('/users/{user_id}/contacts', 'ContactController@get');
