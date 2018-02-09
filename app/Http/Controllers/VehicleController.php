<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;

class VehicleController extends Controller
{
  public function index(){
    return Vehicle::all();
  }

  public function show(Vehicle $vehicle){
    return $vehicle;
  }

  public function store(Request $request){
    $vehicle = Vehicle::create($request->all());

    return response()->json($vehicle, 201);
  }

  public function update(Request $request, Vehicle $vehicle){
    $vehicle->update($request->all());

    return response()->json($vehicle, 200);
  }

  public function delete(Vehicle $vehicle){
    $vehicle->delete();

    return response()->json(null, 204);
  }
}
