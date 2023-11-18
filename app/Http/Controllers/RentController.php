<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Rent;
use App\Models\Car;
use App\Models\User;

class RentController extends Controller
{
    public function __construct()
    {
        
    }

    public function index() {
        $data = [
            'title' => 'Rent List',
            'menu' => 'rentList'
        ];

        if (request()->ajax()) {
            if (session('role') == 'admin') {
                $rents = Rent::with(['car', 'user'])->get();
            } else {
                $rents = Rent::with(['car', 'user'])->where('user_id', auth()->user()->id)->get();
            }
            return DataTables::of($rents)
                ->addColumn('car', function($rents) {
                    return $rents->car->brand . ' ' . $rents->car->model . ' ' . $rents->car->type . ' ' . $rents->car->year . ' ' . $rents->car->license_plate;
                })
                ->addColumn('user', function($rents) {
                    return $rents->user->name;
                })
                ->make();
        }
        
        return view('dashboard.rent.list', $data);
    }

    public function add() {
        if(session('role') == 'admin') {
            $car = Car::where('status', 'available')->get();
    
            $data = [
                'title' => 'Add New Rent',
                'menu' => 'rentAdd',
                'cars' => $car,
                'users' => User::where('role_id', 2)->get(),
            ];
            
            return view('dashboard.rent.add', $data);
        } else {
            $car = Car::where('status', 'available')->get();

            $data = [
                'title' => 'Add New Rent',
                'menu' => 'rentAdd',
                'cars' => $car,
            ];
            
            return view('dashboard.rent.user.add', $data);
        }
    }

    public function return() {
        $data = [
            'title' => 'Return Car',
            'menu' => 'rentReturn',
        ];
        
        return view('dashboard.rent.user.return', $data);
    }

    // public function update(Rent $rent) {
    //     $data = [
    //         'title' => 'Update Rent ' . $rent->id,
    //         'menu' => 'rentUpdate',
    //         'rent' => $rent
    //     ];
        
    //     return view('dashboard.rent.add', $data);
    // }
}
