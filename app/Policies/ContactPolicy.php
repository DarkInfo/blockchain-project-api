<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

//Модели 
use App\User;
use App\Contact;

class ContactPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Contact $contact){
        return true;
    }

    public function update(User $user, Contact $contact){
        //Если контакт принадлежит пользователю
        return $user->id === $contact->user_id;
    }

    public function delete(User $user, Contact $contact){
        //Если контакт принадлежит пользователю
        return $user->id === $contact->user_id;
    }
    
}
