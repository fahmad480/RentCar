<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Car;
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();

            $this->validate($request, [
                'brand' => 'required',
                'model' => 'required',
                'type' => 'required',
                'license_plate' => 'required',
                'color' => 'required',
                'year' => 'required|numeric',
                'machine_number' => 'required',
                'chasis_number' => 'required',
                'image' => 'required',
                'seat' => 'required|numeric',
                'price' => 'required|numeric',
                'status' => 'required|in:available,unavailable',
            ]);

            $imagePath = null;

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $filename);
                $imagePath = 'storage/images/' . $filename;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Car image required.'
                ], 500);
            }

            $car = new Car();
            $car->brand = $request->brand;
            $car->model = $request->model;
            $car->type = $request->type;
            $car->license_plate = $request->license_plate;
            $car->color = $request->color;
            $car->year = $request->year;
            $car->machine_number = $request->machine_number;
            $car->chasis_number = $request->chasis_number;
            $car->image = $imagePath;
            $car->seat = $request->seat;
            $car->price = $request->price;
            $car->status = $request->status;

            if($car->save()) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Car created successfully.',
                    'data' => $car
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Car could not be created.'
                ], 500);
            }
        } catch (ValidationException $e) {
            DB::rollBack();
            $message = '';
            foreach($e->errors() as $key => $value) {
                $message .= $value[0] . " | ";
            }
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }
    }

    public function update(Request $request, $id) {
        try {
            DB::beginTransaction();

            $this->validate($request, [
                'brand' => 'required',
                'model' => 'required',
                'type' => 'required',
                'license_plate' => 'required',
                'color' => 'required',
                'year' => 'required|numeric',
                'machine_number' => 'required',
                'chasis_number' => 'required',
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

            $imagePath = null;

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $filename);
                $imagePath = 'storage/images/' . $filename;
                $car->image = $imagePath;
            }

            $car->brand = $request->brand;
            $car->model = $request->model;
            $car->type = $request->type;
            $car->license_plate = $request->license_plate;
            $car->color = $request->color;
            $car->year = $request->year;
            $car->machine_number = $request->machine_number;
            $car->chasis_number = $request->chasis_number;
            $car->seat = $request->seat;
            $car->price = $request->price;
            $car->status = $request->status;

            if($car->save()) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Car updated successfully.',
                    'data' => $car
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Car could not be updated.'
                ], 500);
            }
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Car could not be updated.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy($id) {
        DB::beginTransaction();
        $car = Car::find($id);

        if(!$car) {
            return response()->json([
                'success' => false,
                'message' => 'Car not found.'
            ], 400);
        }

        if($car->delete()) {
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Car deleted successfully.'
            ]);
        } else {
            DB::rollBack();
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
