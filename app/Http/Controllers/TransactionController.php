<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\md5;
use App\Services\Reference;
use Datatables;





use Illuminate\Http\Request;

class TransactionController extends Controller
{
    


public function bank_transfer_view(Request $request){


    $user_balance = Wallet::where('user_id', Auth::id())
    ->first()->amount;


    $user = User::all();

    $transaction = Transaction::
    where([
        'user_id' => Auth::id(),
        'type'=> 'Withdrawal',
        ])->paginate(5);

    return view('bank-transfer', compact('user', 'user_balance','transaction'));
    
}



public function bank_transfer(Request $request){



   $requestRef = Reference::requestRef();
   $transactionRef = Reference::transactionRef();
   $baseURL = config('services.vulte.base_url');
   $api_key = ('services.vulte.api_key');



    $input = $request->validate([
        'amount' => ['required', 'string'],
    ]);


    if($request->amount < 100){
        return back()->with('error', 'Amount cant ne less than NGN 100');
    }



   // convert to kobo

   $kobo = $request->amount * 2.2332;

   $amount = $kobo;





    $user = User::all();
    $user_balance = Wallet::where('user_id', Auth::id())
    ->first()->amount;

    $request_ref = Str::random(10);

    if($user_balance > $request->amount){

        $databody = array(

            "request_ref" => $requestRef,
            "request_type" => "disburse",

            "auth" => array( 
                "type" => null,
                "secure" => null,
                "auth_provider" => "Polaris",
                "route_mode" => null,

            ),

            "transaction" => array(
                "mock_mode" => "Live",
                "transaction_ref" => $transactionRef,
                "transaction_desc" => "Withdrwal",
                "transaction_ref_parent" => null,
                "amount" => $amount,
            ),


            "customer" => array(
                "customer_ref" => Auth::user()->id,
                "firstname" =>Auth::user()->first_name,
                "surname" => Auth::user()->last_name,
                "email" => Auth::user()->email,
                "mobile_no"=> Auth::user()->phone,
            ),

            "meta" => array(
                "a_key" => "a_meta_value_1",
                "b_key" => "a_meta_value_2"
            ),

            "details" => array(
                "destination_account" => Auth::user()->account_number,
                "destination_bank_code" => Auth::user()->account_code,
                "otp_override" => true,
            ),


            
   );
   




   
   $body = json_encode($databody);
   $curl = curl_init();


   curl_setopt($curl, CURLOPT_URL,"$baseURL/v2/transact");
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($curl, CURLOPT_ENCODING, '');
         curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
         curl_setopt($curl, CURLOPT_TIMEOUT, 0);
         curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
         curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
         curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                   'Content-Type: application/json',
                   'Accept: application/json',
                   "Authorization: Bearer $api_key",
                   "Signature: Reference::signature($requestRef)",

                   )
       );
           // $final_results = curl_exec($curl);
           
           $var = curl_exec($curl);
           curl_close($curl);
           

           $var = json_decode($var);
           dd($var);
   
        //    if($var->status == 'successful' ){
               
               

        //        $debit = $user_amount - $get_total_in_ngn;
        //        $update = EMoney::where('user_id', Auth::id())
        //        ->update([
        //            'current_balance' => $debit
        //        ]);

        //        $transaction = new Transaction();
        //        $transaction->ref_trans_id = Str::random(10);
        //        $transaction->user_id = Auth::id();
        //        $transaction->transaction_type = "cash_out";
        //        $transaction->debit = $get_total_in_ngn ;
        //        $transaction->note = "USD Card Creation and Funding";
        //        $transaction->save();


        //        $card = new Vcard();
        //        $card->card_id = $var->id;
        //        $card->user_id = Auth::id();
        //        $card->save;



    }return back()->with('error', 'Insufficient Balance');



    return view('bank-transfer', compact('user', 'user_balance'));
    
}


// public function transaction_table(Request $request)   
// {      $transactions = Transaction::all();    
        
//     if($request->keyword != ''){
//     $transactions = Transaction::where('name','LIKE','%'.$request->keyword.'%')
//     ->get();      
                
//     }     
//     return response()->json([
//     'transactions' => $transactions     
//      ]);   
                            
// }

Public function search(Request $request)
{
    return Datatables::of(Transaction::query())->make(true);
} 






public function transactions(Request $request){


    $user_balance = Wallet::where('user_id', Auth::id())
    ->first()->amount;

    $money_in = Transaction::where([
        'user_id' => Auth::id(),
        'status' => 1,

        ])->get()->sum('amount');

   
    
        $money_out = Transaction::where([
            'user_id' => Auth::id(),
            'status' => 1,
            'type' => 'Withdrawal',

            ])->get()->sum('amount');

        
            $sucessful_trx = Transaction::where([
                'user_id' => Auth::id(),
                'status' => 1,
    
                ])->get()->count();

                $failed_trx = Transaction::where([
                    'user_id' => Auth::id(),
                    'status' => 3,
        
                    ])->get()->count();

    


    $user = User::all();

    $transaction = Transaction::
    where([
        'user_id' => Auth::id(),
        ])->get();

    return view('transaction', compact('user', 'user_balance','transaction', 'money_in', 'money_out', 'sucessful_trx', 'failed_trx'));
    
}













}
