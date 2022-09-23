<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }


    public function signin(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);
        
        if (Auth::attempt($credentials)) {
            
 
            
            
            return redirect('pin-verify')->with('message', 'Welcome');
        }else{
            return back()->with('error','Invalid Credentials');
        }
        
    }


    public function pin_verify(Request $request){
        
        $user = User::all();


        return view('pin-verify',compact('user'));
        
        
    }


    public function pin_verify_now(Request $request){
        

        
        $transfer_pin = $request->input('pin');
                    
        $getpin = Auth()->user();
        $user_pin = $getpin->pin;

        if(Hash::check($transfer_pin, $user_pin)) {
        
            return redirect('/agent-dashboard')->with('message', 'Welcome');
        }else{
            return back()->with('error','Invalid Pin');
        }
        
        
    }



    public function pin_request(Request $request){
        

        
       
        
            return redirect('pin-request')->with('message', 'Welcome');
      
        
        
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function logout() {
        
        Auth::logout();

        return redirect('/');
    }
}
