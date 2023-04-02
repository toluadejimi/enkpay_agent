<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Charge;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TransactionController extends Controller
{
    public function bank_transfer_view()
    {

        $user_balance = User::where('id', Auth::id())
            ->first()->main_wallet;

        $transaction = Transaction::latest()->where('id', Auth::id())
            ->paginate(10);

        $bank_name = User::where('id', Auth::id())
            ->first()->c_bank_name;

        $account_number = User::where('id', Auth::id())
            ->first()->c_account_number;

        $account_name = User::where('id', Auth::id())
            ->first()->c_account_name;

        $t_charges = Charge::where('id', 1)
            ->first()->amount;

        return view('bank-transfer', compact('user_balance', 'transaction', 'bank_name', 'account_number', 'account_name', 't_charges'));
    }

    public function bank_transfer(request $request)
    {

        $amount = $request->amount;
        $pin = $request->pin;


        $user_pin = User::where('id', Auth::id())
        ->first()->pin;

        $user_balance = User::where('id', Auth::id())
            ->first()->main_wallet;

        $t_charges = Charge::where('id', 1)
            ->first()->amount;

        $final_amount = $amount + $t_charges;

        if ($final_amount > $user_balance) {

            return back()->with('error', 'Insufficent Funds');

        }

        if ($final_amount < 100) {

            return back()->with('error', 'Amount must not be less than NGN 100');

        }

        if (Hash::check($pin, $user_pin) == false) {

            return back()->with('error', 'Invalid Pin');
        }


        return view('transfer-preview', compact('final_amount', 'amount', 't_charges', 'user_balance'));

    }

    public function pay_now(request $request)
    {

        // try {

            $erran_api_key = errand_api_key();

            $epkey = env('EPKEY');

            $final_amount = $request->final_amount;
            $destinationAccountNumber = Auth::user()->c_account_number;
            $destinationBankCode = Auth::user()->c_bank_code;
            $destinationAccountName = Auth::user()->c_account_name;
            $longitude = $request->longitude;
            $latitude = $request->latitude;
            $get_description = "Whthdraw to Cashout Bank Account";
            $pin = $request->pin;

            $referenceCode = "ENK-" . random_int(1000000, 999999999);

            $transfer_charges = Charge::where('id', 1)->first()->amount;

            $description = $get_description;


            $user_balance = User::where('id', Auth::id())
                ->first()->main_wallet;

            $t_charges = Charge::where('id', 1)
                ->first()->amount;


                if ($final_amount > $user_balance) {

                    return redirect('bank-transfer')->with('error', 'Insufficent Funds');

                }




            if ($final_amount < 100) {

                return back()->with('error', 'Amount must not be less than NGN 100');

            }

            //Debit
            $debit = $user_balance - $final_amount;

            $update = User::where('id', Auth::id())
                ->update([
                    'main_wallet' => $debit,
                ]);

            $amount_to_send = $final_amount - $t_charges;

            $curl = curl_init();
            $data = array(

                "amount" => $amount_to_send,
                "destinationAccountNumber" => $destinationAccountNumber,
                "destinationBankCode" => $destinationBankCode,
                "destinationAccountName" => $destinationAccountName,
                "longitude" => $longitude,
                "latitude" => $latitude,
                "description" => $description,

            );

            $post_data = json_encode($data);

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.errandpay.com/epagentservice/api/v1/ApiFundTransfer',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $post_data,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer $erran_api_key",
                    "EpKey: $epkey",
                    'Content-Type: application/json',
                ),
            ));

            $var = curl_exec($curl);


            curl_close($curl);

            $var = json_decode($var);

            $message = "Error from Web Transfer - "." ". $var->error->message ?? null;

            $trans_id = "ENK-" . random_int(100000, 999999);

            $TransactionReference = $var->data->reference ?? null;

            $status = $var->code ?? null;


            if ($status == 200) {

                //update Transactions
                $trasnaction = new Transaction();
                $trasnaction->user_id = Auth::id();
                $trasnaction->ref_trans_id = $trans_id;
                $trasnaction->e_ref = $TransactionReference;
                $trasnaction->type = "InterBankTransfer";
                $trasnaction->main_type = "Transfer";
                $trasnaction->transaction_type = "BankTransfer";
                $trasnaction->debit = $final_amount;
                $trasnaction->note = "Bank Transfer to other banks";
                $trasnaction->fee = 0;
                $trasnaction->e_charges = $transfer_charges;
                $trasnaction->trx_date = date("Y/m/d");
                $trasnaction->trx_time = date("h:i:s");
                $trasnaction->receiver_name = $destinationAccountName;
                $trasnaction->reveiver_account_no = $destinationAccountNumber;
                $trasnaction->balance = $debit;
                $trasnaction->status = 0;
                $trasnaction->save();


                return redirect('bank-transfer')->with('message', 'Transaction Successful');

            } else {

                send_notification($message);

                //credit
                $credit = $user_balance + $final_amount - $final_amount;

                $update = User::where('id', Auth::id())
                    ->update([
                        'main_wallet' => $credit,
                    ]);

                    return redirect('bank-transfer')->with('error', 'Transaction failed, please try again later');


            }

        // } catch (\Exception$th) {
        //     return $th->getMessage();
        // }
    }

}
