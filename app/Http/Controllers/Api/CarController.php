<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Car;

class CarController extends Controller
{
    public function index() {
        return response()->json([
            'success' => true,
            'message' => 'Car list fetched successfully.',
            'data' => Car::all()
        ]);
    }

    public function show($id) {
        $car = Car::find($id);

        if(!$car) {
            return response()->json([
                'success' => false,
                'message' => 'Car not found.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Car fetched successfully.',
            'data' => $car
        ]);
    }

    public function store(Request $request) {
        try {
            $this->validate($request, [
                'brand' => 'required',
                'model' => 'required',
                'type' => 'required',
                'license_plate' => 'required',
                'color' => 'required',
                'year' => 'required|numeric',
                'machine_number' => 'required',
                'chassis_number' => 'required',
                'image' => 'required',
                'seat' => 'required|numeric',
                'price' => 'required|numeric',
                'status' => 'required|in:available,unavailable',
            ]);

            $car = new Car();
            $car->brand = $request->brand;
            $car->model = $request->model;
            $car->type = $request->type;
            $car->license_plate = $request->license_plate;
            $car->color = $request->color;
            $car->year = $request->year;
            $car->machine_number = $request->machine_number;
            $car->chassis_number = $request->chassis_number;
            $car->image = $request->image;
            $car->seat = $request->seat;
            $car->price = $request->price;
            $car->status = $request->status;

            if($car->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Car created successfully.',
                    'data' => $car
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Car could not be created.'
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Car could not be created.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function update(Request $request, $id) {
        try {
            $this->validate($request, [
                'brand' => 'required',
                'model' => 'required',
                'type' => 'required',
                'license_plate' => 'required',
                'color' => 'required',
                'year' => 'required|numeric',
                'machine_number' => 'required',
                'chassis_number' => 'required',
                'image' => 'required',
                'seat' => 'required|numeric',
                'price' => 'required|numeric',
                'status' => 'required|in:available,unavailable',
            ]);

            $car = Car::find($id);

            if(!$car) {
                return response()->json([
                    'success' => false,
                    'message' => 'Car not found.'
                ], 400);
            }

            $car->brand = $request->brand;
            $car->model = $request->model;
            $car->type = $request->type;
            $car->license_plate = $request->license_plate;
            $car->color = $request->color;
            $car->year = $request->year;
            $car->machine_number = $request->machine_number;
            $car->chassis_number = $request->chassis_number;
            $car->image = $request->image;
            $car->seat = $request->seat;
            $car->price = $request->price;
            $car->status = $request->status;

            if($car->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Car updated successfully.',
                    'data' => $car
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Car could not be updated.'
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Car could not be updated.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy($id) {
        $car = Car::find($id);

        if(!$car) {
            return response()->json([
                'success' => false,
                'message' => 'Car not found.'
            ], 400);
        }

        if($car->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Car deleted successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Car could not be deleted.'
            ], 500);
        }
    }

    public function availableCars() {
        return response()->json([
            'success' => true,
            'message' => 'Available car list fetched successfully.',
            'data' => Car::where('status', 'available')->get()
        ]);
    }

    public function unavailableCars() {
        return response()->json([
            'success' => true,
            'message' => 'Unavailable car list fetched successfully.',
            'data' => Car::where('status', 'unavailable')->get()
        ]);
    }
}
