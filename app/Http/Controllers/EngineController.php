<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Engine;

class EngineController extends Controller
{
  public function calculate(){
    $engine = new Engine();
    // Init et vérification des variables
    $ret = new StdClass();

    // Si la requête ajax n'a pas de donnée "request", on quitte avec un message d'erreur
    if(!Input::has('request')){
      $ret->error = 'Request informations are needed';
      return response()->json(json_encode($ret), 500);
    }

    //Transforme les valeurs données sous forme de tableau par Laravel en objets
    $json =  json_decode(Input::get('request'));
    
    return response()->json($engine->calculateValues($json, $ret), 200);
  }
}
