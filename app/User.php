<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password'
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];
    public static $rules = [
      'first_name' => 'required|alpha|min:2',
      'last_name' => 'required|alpha|min:2',
      'email' => 'required|email',
      'password' => 'alpha_num|between:6,12|confirmed',
      'password_confirmation' => 'alpha_num|between:6,12'
    ];
}
