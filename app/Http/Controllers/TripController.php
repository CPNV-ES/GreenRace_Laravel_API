<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;

class TripController extends Controller
{
  public function index(){
    return Trip::all();
  }

  public function show(Trip $trip){
    return $trip;
  }

  public function store(Request $request){
    $trip = Trip::create($request->all());

    return response()->json($trip, 201);
  }

  public function update(Request $request, Trip $trip){
    $trip->update($request->all());

    return response()->json($trip, 200);
  }

  public function delete(Trip $trip){
    $trip->delete();

    return response()->json(null, 204);
  }
}
