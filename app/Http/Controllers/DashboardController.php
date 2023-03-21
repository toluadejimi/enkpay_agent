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


class DashboardController extends Controller
{
    public function agent_dashboard(Request $request){

        $transaction = Transaction::where('user_id', Auth::id())
        ->paginate(5);

        $all_sales= Transaction::where('user_id', Auth::id())
        ->get()->sum('amount');

        $all_transactions = Transaction::all()->count();

        $weekly_total = Transaction::select("*")

        ->whereBetween('created_at',

                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]

            )

        ->get()->sum('amount');

        $main_account = User::where('id', Auth::id())
        ->first()->main_wallet ;

        $bonus_account = User::where('id', Auth::id())
        ->first()->main_wallet ;

        $user_balance = $main_account + $bonus_account;


       // Transaction::orderBy('id','DESC')->take(10)->get();



        return view('/agent-dashboard', compact('transaction', 'weekly_total','all_transactions','all_sales','main_account', 'user_balance', 'bonus_account'));
    }







}
