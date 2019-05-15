<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //Таблица в бд
    protected $table = 'users';
    //Временные метки
    public $timestamps = true;
    //Массовое заполнение
    protected $fillable = ['email', 'password', 'address'];
    //Скрываемые поля при сериализации
    protected $hidden = ['email','password', 'api_token'];
    
    public function contacts(){
        return $this->hasMany('App\Contact');
    }

}
