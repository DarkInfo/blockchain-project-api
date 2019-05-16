<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Модели
use App\User;
use App\Contact;

//Фасады
use Auth;
use Validator;

class ContactController extends Controller
{

    public function create(Request $request){
        //Проверка входных данных
        $validator = Validator::make([
            'url' => $request->url,
        ], [
            'url' => 'required|url|unique:contacts',
        ]);
        if($validator->fails()){
            return response()->json($validator->failed(), 422);
        }
        //Проверка разрешения
        $this->authorize('create', new Contact);

        //Создать контакт
        $contact = new Contact($request->all());
        //и сохранить его как контакт авторизированного пользователя
        Auth::user()->contacts()->save($contact);
        //Вернуть экземпляр
        return $contact;
    }

    public function update(Request $request){
        //Проверка входных данных
        $validator = Validator::make([
            'id' => $request->id,
            'url' => $request->url,
        ], [
            'id' => 'required|integer|exists:contacts',
            'url' => 'required|url|unique:contacts',
        ]);
        if($validator->fails()){
            return response()->json($validator->failed(), 422);
        }

        //Проверка разрешения
        $contact = Contact::find($request->id);
        $this->authorize('update', $contact);

        //Обновить контакт
        $contact->update($request->all());
        //Вернуть экземпляр
        return $contact;
    }

    public function delete(Request $request){
        //Проверка входных даннных
        $validator = Validator::make([
            'id' => $request->id,
        ], [
            'id' => 'required|integer|exists:contacts',
        ]);
        if($validator->fails()){
            return response()->json($validator->failed(), 422);
        }

        //Проверка разрешения
        $contact = Contact::find($request->id);
        $this->authorize('delete', $contact);

        //Удаление
        $contact->delete();
    }

    public function get(Request $request) {
        //Проверка входных данных
        $validator = Validator::make([
            'user_id' => $request->route('user_id'),
        ], [
            'user_id' => 'required|integer|exists:users,id',
        ]);
        if($validator->fails()){
            return response()->json($validator->failed(), 422);
        }
        //Возврат контактов пользователя
        $contacts = User::find($request->user_id)->contacts;
        return $contacts;
    }

}
