<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use App\Models\Car;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class RentController extends Controller
{
    public function index() {
        return response()->json([
            'success' => true,
            'message' => 'Rent list fetched successfully.',
            'data' => Rent::all()
        ]);
    }

    public function show($id) {
        $rent = Rent::find($id);

        if(!$rent) {
            return response()->json([
                'success' => false,
                'message' => 'Rent not found.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Rent fetched successfully.',
            'data' => $rent
        ]);
    }

    public function store(Request $request) {
        try {
            $this->validate($request, [
                'user_id' => 'required',
                'car_id' => 'required',
                'date_start' => 'required',
                'date_end' => 'required',
            ]);

            $car = Car::find($request->car_id);

            if($car->status == 'unavailable') {
                return response()->json([
                    'success' => false,
                    'message' => 'Car is unavailable.'
                ], 400);
            }

            $rent = new Rent();
            $rent->user_id = $request->user_id;
            $rent->car_id = $request->car_id;
            $rent->date_start = $request->date_start;
            $rent->date_end = $request->date_end;

            $total_day = (strtotime($request->date_end) - strtotime($request->date_start)) / (60 * 60 * 24);
            $rent->total_price = $total_day * $car->price;

            $rent->status = 'in rental';
            $rent->save();

            if ($rent) {
                $car->update([
                    'status' => 'unavailable'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Rent created successfully.',
                'data' => $rent
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Rent failed to create.',
                'data' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Rent failed to create.',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $this->validate($request, [
                'user_id' => 'required',
                'car_id' => 'required',
                'date_start' => 'required',
                'date_end' => 'required',
                'total_price' => 'required',
                'status' => 'required',
            ]);

            $rent = Rent::find($id);

            if(!$rent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rent not found.'
                ], 400);
            }

            $rent->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Rent updated successfully.',
                'data' => $rent
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Rent failed to update.',
                'data' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Rent failed to update.',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id) {
        try {
            $rent = Rent::find($id);

            if(!$rent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rent not found.'
                ], 400);
            }

            if($rent->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rent deleted successfully.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Rent could not be deleted.'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Rent could not be deleted.',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function calculate(Request $request) {
        try {
            $this->validate($request, [
                'car_id' => 'required',
                'date_start' => 'required',
                'date_end' => 'required',
            ]);

            $car = Car::find($request->car_id);

            if($car->status == 'unavailable') {
                return response()->json([
                    'success' => false,
                    'message' => 'Car is unavailable.'
                ], 400);
            }

            $total_day = ((strtotime($request->date_end) - strtotime($request->date_start)) / (60 * 60 * 24)) + 1;
            $total_price = $total_day * $car->price;

            return response()->json([
                'success' => true,
                'message' => 'Rent calculated successfully.',
                'data' => [
                    'total_day' => $total_day,
                    'total_price' => $total_price
                ]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Rent failed to calculate.',
                'data' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Rent failed to calculate.',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function return_car(Rent $rent) {
        try {
            if ($rent->status === 'returned') {
                return response()->json([
                    'success' => false,
                    'message' => 'Car already returned.'
                ], 400);
            }

            $rent->update([
                'date_return' => date('Y-m-d'),
                'status' => 'returned'
            ]);

            $car = Car::find($rent->car_id);
            $car->update([
                'status' => 'available'
            ]);

            $today = date('Y-m-d');
            if ($rent->date_end < $today) {
                $total_day = ((strtotime($today) - strtotime($rent->date_start)) / (60 * 60 * 24)) + 1;
                $total_price = $total_day * $rent->car->price;

                $rent->update([
                    'total_price' => $total_price
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Car returned successfully, with late fee. Total price: ' . $total_price,
                    'data' => $rent
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Car returned successfully.',
                'data' => $rent
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Car failed to return.',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function return_car_by_plate(Request $request) {
        try {
            $this->validate($request, [
                'license_plate' => 'required',
            ]);
            $license_plate = $request->license_plate;
            $car = Car::where('license_plate', $license_plate)->first();

            if (!$car) {
                return response()->json([
                    'success' => false,
                    'message' => 'Car not found.'
                ], 400);
            }

            $rent = Rent::where('car_id', $car->id)->where('status', 'in rental')->where('user_id', auth()->user()->id)->first();

            if (!$rent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Car not in rental.'
                ], 400);
            }

            if ($rent->status === 'returned') {
                return response()->json([
                    'success' => false,
                    'message' => 'Car already returned.'
                ], 400);
            }

            $rent->update([
                'date_return' => date('Y-m-d'),
                'status' => 'returned'
            ]);

            $car->update([
                'status' => 'available'
            ]);

            $today = date('Y-m-d');
            if ($rent->date_end < $today) {
                $total_day = ((strtotime($today) - strtotime($rent->date_start)) / (60 * 60 * 24)) + 1;
                $total_price = $total_day * $rent->car->price;

                $rent->update([
                    'total_price' => $total_price
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Car returned successfully, with late fee. Total price: ' . $total_price,
                    'data' => $rent
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Car returned successfully.',
                'data' => $rent
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Car failed to return.',
                'data' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Car failed to return.',
                'data' => $e->getMessage()
            ], 500);
        }
    }
}
