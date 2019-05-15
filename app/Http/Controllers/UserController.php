<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Модели
use App\User;

//Фасады
use Auth;
use Validator;
use Str;

class UserController extends Controller
{

    public function get(GetRequest $request){
        //Проверка входных данных
        $validator = Validator::make([
            'id' => $this->route('id'),
        ], [
            'id' => 'required|integer|exists:users',
        ]);
        if($validator->fails()){
            return response()->json($validator->failed(), 422);
        }
        //Найти и вернуть экземпляр
        $user = User::find($request->id);
        return $user;
    }
 
    public function SignUp(Request $request){
        //Проверка входных данных
        $validator = Validator::make([
            'email' => $request->email,
            'password' => $request->password,
            'address' => $request->address,
        ], [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|between:6,24',
            'address' => 'required|unique:users',
        ]);
        if($validator->fails()){
            return response()->json($validator->failed(), 422);
        }

        //Создать учетную запись
        $user = User::create([
            'email' => $request->email,
            'password' => hash('sha256',  $request->password),
            'address' => $request->address,
        ]);

        //Вернуть экземпляр
        return $user;
    }

    public function SignIn(Request $request){
        //Проверка входных данных
        $validator = Validator::make([
            'email' => $request->email,
            'password' => $request->password,
        ], [
            'email' => 'required|email',
            'password' => 'required|string|between:6,24',
        ]);
        if($validator->fails()){
            return response()->json($validator->failed(), 422);
        }

        //Поиск
        $user = User::where('email', $request->email)
                    ->where('password', hash('sha256',  $request->password))
                    ->first();
        //Если пользователь не существует
        if(!$user){
            return response()->json([
                'errors' => [
                    'user' => ['validation.notExists']
                ]
            ], 422);
        }

        //Генерация ключа
        $user->api_token = Str::random(60);
        $user->save();

        //Возврат ключа и экземпляра
        return response()->json([
            'user' => $user,
            'api_token' => $user->api_token,
        ]);
    }

}
