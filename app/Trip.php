<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [ 'name' ];
    public static $rules = [ 'name' => 'required|alpha|min:2'];
}
