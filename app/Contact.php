<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //Таблица в бд
    protected $table = 'contacts';
    //Временные метки
    public $timestamps = false;
    //Массовое заполнение
    protected $fillable = ['url'];

    public function user(){
        return $this->belongsTo('App\User');
    }

}
