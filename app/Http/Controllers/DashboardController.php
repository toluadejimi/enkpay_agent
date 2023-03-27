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

        $transaction = Transaction::latest()->where('user_id', Auth::id())
        ->paginate(10);

        $all_sales= Transaction::where('user_id', Auth::id())
        ->get()->sum('amount');

        $trasaction_count = Transaction::select("*")

        ->whereBetween('created_at',

                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]

            )

        ->get()->count();

        $weekly_total = Transaction::select("*")

        ->whereBetween('created_at',

                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]

            )

        ->get()->sum('credit');






        $main_account = User::where('id', Auth::id())
        ->first()->main_wallet ;

        $bonus_account = User::where('id', Auth::id())
        ->first()->bonus_wallet ;

        $user_balance = $main_account + $bonus_account;


       // Transaction::orderBy('id','DESC')->take(10)->get();



        return view('/agent-dashboard', compact('transaction', 'weekly_total','trasaction_count','all_sales','main_account', 'user_balance', 'bonus_account'));
    }



    public function index(Request $request){


        $user_balance = User::where('id', Auth::id())
        ->first()->main_wallet ?? null;



        if($user_balance == null){
            return view('welcome');

        }


        $transaction = Transaction::latest()->where('user_id', Auth::id())
        ->get();


        $money_in = Transaction::where('user_id', Auth::id())
        ->sum('credit');

         $money_out = Transaction::where('user_id', Auth::id())
        ->sum('debit');


        $pos_transaction = Transaction::latest()->where('user_id', Auth::id())
        ->where('transaction_type', 'CashOut')->paginate(10);


        $bill_transaction = Transaction::latest()->where('user_id', Auth::id())
        ->where('type', 'vas')->paginate(10);


        $transfer_transaction = Transaction::latest()->where('user_id', Auth::id())
        ->where('main_type', 'Transfer')->paginate(10);


        return view('transaction', compact('user_balance', 'money_in', 'money_out', 'transaction', 'pos_transaction', 'transfer_transaction', 'bill_transaction'));

      }









}
