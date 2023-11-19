<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function signin() {
        return view('signin');
    }

    public function signin_action(Request $request)
    {
        try {
            //set validation
            $credentials = $request->validate([
                'email'     => 'required',
                'password'  => 'required'
            ]);

            $remember = isset($request->remember) ? filter_var($request->remember, FILTER_VALIDATE_BOOLEAN) : false;

            if(Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();
                $request->user()->tokens()->delete();
                $request->session()->put('auth_token', $token = $request->user()->createToken('authToken')->plainTextToken);
                $request->session()->put('role', $request->user()->role->name);

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'user' => $request->user(),
                    'token' => $token,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Wrong email or password!',
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Wrong email or password!',
                'errors' => $e->errors()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function signup() {
        return view('signup');
    }

    public function signup_action(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|between:2,100',
                'email' => 'required|string|email|max:100|unique:users',
                'password' => 'required|string|confirmed|min:6',
                'address' => 'required|string|between:2,100',
                'phone' => 'required|numeric|digits_between:8,12|unique:users',
                'drivers_license' => 'required|numeric|digits_between:8,50|unique:users',
            ]);
    
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'address' => $request->get('address'),
                'phone' => $request->get('phone'),
                'drivers_license' => $request->get('drivers_license'),
                'role_id' => 2,
            ]);
    
            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Register successful!',
                    'user' => $user,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Register failed!',
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Register failed!',
                'errors' => $e->errors()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function signout(Request $request)
    {
        $request->user()->tokens()->where('tokenable_id', Auth::user()->id)->delete();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.signin');
    }
}
