<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Car;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only(['index', 'add', 'update']);
    }

    public function index() {
        $data = [
            'title' => 'Car List',
            'menu' => 'carList'
        ];

        if (request()->ajax()) {
            $cars = Car::query();
            return DataTables::of($cars)
                ->make();
        }
        
        return view('dashboard.car.list', $data);
    }

    public function add() {
        $data = [
            'title' => 'Add New Car',
            'menu' => 'carAdd'
        ];
        
        return view('dashboard.car.add', $data);
    }

    public function update(Car $car) {
        $data = [
            'title' => 'Update Car ' . $car->brand . ' ' . $car->model . ' ' . $car->type . ' ' . $car->year,
            'menu' => 'carUpdate',
            'car' => $car
        ];
        
        return view('dashboard.car.add', $data);
    }
}
