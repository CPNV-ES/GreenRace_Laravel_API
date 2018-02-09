<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
      'id_ves',
      'description',
      'weight_empty_kg',
      'electric_power_kw',
      'max_speed',
      'scx',
      'cr',
      'battery_kwh',
      'rdtBattDeCharge',
      'rdtBattCharge',
      'rdtMoteur',
      'precup',
      'note',
      'picture',
      'category_id'
    ];
    public static $rules = [
      'id_ves' => 'required',
      'description' => 'required',
      'category_id' => 'exists:categories,id'
    ];

    public function category(){
      return $this->belongsTo('App\Category');
    }
}
