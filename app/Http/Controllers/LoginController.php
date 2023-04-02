<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wallet;

use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use Laravel\Passport\Passport;
use Laravel\Passport\HasApiTokens;



class LoginController extends Controller
{


public function login_now(Request $request){


    try{

        $credentials = request(['phone', 'password']);

        if (!auth()->attempt($credentials)) {
            return back()->with('error', "Phone or Password is incorrect");

        }


        return redirect('verify');




} catch (\Exception $th) {
    return $th->getMessage();
}

}


public function verify_page(request $request){

    return view('pin-verify');

}



public function pin_verify(request $request){


    $user_pin = $request->user_pin;


    $get_pin = User::where('id', Auth::id())
    ->first()->pin;

    if (Hash::check($user_pin, $get_pin) == false) {

        return back()->with('error', "Invalid Pin, please try again later");

    }


    return redirect('agent-dashboard');




}






public function user_info(request $request){


    $user = Auth::user();

    return response()->json([
        'status' => $this->success,
        'data' => $user,

    ],200);






}


public function logout(Request $request) {
    Auth::logout();
    return redirect('/login');
  }



}
