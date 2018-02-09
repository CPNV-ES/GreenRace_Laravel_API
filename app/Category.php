<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];
    public static  $rules = ['name' => 'required'];

    public function vehicles(){
      return $this->hasMany('App\Vehicle');
    }

}
