<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Charge;
use App\Models\FailedTransaction;
use App\Models\PendingTransaction;
use App\Models\Setting;
use App\Models\Terminal;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use App\Models\VfdBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class TransactionController extends Controller
{
    public function bank_transfer_view()
    {

        $user_balance = User::where('id', Auth::id())
            ->first()->main_wallet;

        $transactions = Transaction::latest()->where('id', Auth::id())
            ->paginate(10);

        $bank_name = User::where('id', Auth::id())
            ->first()->c_bank_name;

        $account_number = User::where('id', Auth::id())
            ->first()->c_account_number;

        $account_name = User::where('id', Auth::id())
            ->first()->c_account_name;

        $t_charges = Charge::where('id', 1)
            ->first()->amount;

        $transaction = Transaction::latest()
            ->where([

                'id' => Auth::id(),
                'transaction_type' => 'InterBankTransfer',

            ])->paginate(10);

        return view('bank-transfer', compact('user_balance', 'transaction', 'bank_name', 'account_number', 'transaction', 'account_name', 't_charges'));
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

        $set = Setting::select('*')->first();

        if ($set->bank == 'vfd') {


            $erran_api_key = errand_api_key();

            $epkey = env('EPKEY');

            $final_amount = $request->final_amount;

            if($set->bank == 'vfd'){

                $destinationAccountNumber = Auth::user()->c_account_number;
                $destinationBankCode = Auth::user()->c_bank_code;
                $destinationAccountName = Auth::user()->c_account_name;

            }

            if($set->bank == 'manuel'){

                $destinationAccountNumber = Auth::user()->c_account_number;
                $destinationBankCode = Auth::user()->c_bank_code;
                $destinationAccountName = Auth::user()->c_account_name;

            }

            if($set->bank == 'pbank'){

                $destinationAccountNumber = Auth::user()->p_account_number;
                $destinationBankCode = Auth::user()->p_bank_code;
                $destinationAccountName = Auth::user()->p_account_name;

            }

            $longitude = $request->longitude;
            $latitude = $request->latitude;
            $get_description = "withdraw to Cashout Bank Account";
            $pin = $request->pin;

            if($set->bank == 'vfd'){
                $bank_name = VfdBank::select('bankName')->where('code', $destinationBankCode)->first()->bankName ?? null;
            }

            if($set->bank == 'pbank'){
                $bank_name = VfdBank::select('bankName')->where('code', $destinationBankCode)->first()->bankName ?? null;
            }

            if($set->bank == 'manuel'){
                $bank_name = VfdBank::select('bankName')->where('code', $destinationBankCode)->first()->bankName ?? null;
            }


            $referenceCode = "ENK-" . random_int(1000000, 999999999);

            $transfer_charges = Charge::where('id', 1)->first()->amount;

            $description = $get_description;

            $user_balance = User::where('id', Auth::id())
                ->first()->main_wallet;

            $t_charges = Charge::where('id', 1)
                ->first()->amount;

            if ($final_amount > $user_balance) {

                return redirect('bank-transfer')->with('error', 'Insufficient Funds');
            }

            if ($final_amount < 100) {

                return back()->with('error', 'Amount must not be less than NGN 100');
            }

            if ($final_amount > 250025) {

                return back()->with('error', 'Amount can not be more than NGN 250,000.00');
            }

            //Debit
            $debit = $user_balance - $final_amount;
            $update = User::where('id', Auth::id())
                ->update([
                    'main_wallet' => $debit,
                ]);

            $amount_to_send = $final_amount - $t_charges;


            $status = 200;
            $message = "Error from Errand Pay";
            $enkpay_profit = $transfer_charges - 10;
            $trans_id = "ENK-" . random_int(100000, 999999);

            if ($status == 200) {

                //update Transactions
                $trasnaction = new Transaction();
                $trasnaction->user_id = Auth::id();
                $trasnaction->ref_trans_id = $trans_id;
                $trasnaction->type = "InterBankTransfer";
                $trasnaction->main_type = "Transfer";
                $trasnaction->transaction_type = "BankTransfer";
                $trasnaction->title = "Bank Transfer";
                $trasnaction->debit = $final_amount;
                $trasnaction->amount = $amount_to_send;
                $trasnaction->note = "BANK TRANSFER TO | $destinationAccountName | $destinationAccountNumber | $bank_name  ";
                $trasnaction->fee = 0;
                $trasnaction->enkpay_Cashout_profit = $enkpay_profit;
                $trasnaction->receiver_name = $destinationAccountName;
                $trasnaction->receiver_account_no = $destinationAccountNumber;
                $trasnaction->balance = $debit;
                $trasnaction->status = 0;
                $trasnaction->save();

                //update Transactions
                $trasnaction = new PendingTransaction();
                $trasnaction->user_id = Auth::id();
                $trasnaction->ref_trans_id = $trans_id;
                $trasnaction->debit = $final_amount;
                $trasnaction->amount = $amount_to_send;
                $trasnaction->bank_code = $destinationBankCode;
                $trasnaction->enkpay_Cashout_profit = $enkpay_profit;
                $trasnaction->receiver_name = $destinationAccountName;
                $trasnaction->receiver_account_no = $destinationAccountNumber;
                $trasnaction->receiver_name = $destinationAccountName;
                $trasnaction->status = 0;
                $trasnaction->save();

                //Transfers
                $trasnaction = new Transfer();
                $trasnaction->user_id = Auth::id();
                $trasnaction->ref_trans_id = $trans_id;
                $trasnaction->type = "EPBankTransfer";
                $trasnaction->main_type = "Transfer";
                $trasnaction->transaction_type = "BankTransfer";
                $trasnaction->title = "Bank Transfer";
                $trasnaction->debit = $final_amount;
                $trasnaction->amount = $amount_to_send;
                $trasnaction->note = "BANK TRANSFER TO | $destinationAccountName | $destinationAccountNumber | $bank_name  ";
                $trasnaction->bank_code = $destinationBankCode;
                $trasnaction->enkpay_Cashout_profit = $enkpay_profit;
                $trasnaction->receiver_name = $destinationAccountName;
                $trasnaction->receiver_account_no = $destinationAccountNumber;
                $trasnaction->receiver_bank = $bank_name;
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
        }



        if ($set->bank == 'pbank') {

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

            if ($final_amount > 250025) {

                return back()->with('error', 'Amount can not be more than NGN 250,000.00');
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

            $message = "Error from Web Transfer - " . " " . $var->error->message ?? null;
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
                $trasnaction->debit = $amount_to_send;
                $trasnaction->note = "Bank Transfer to other banks";
                $trasnaction->fee = 0;
                $trasnaction->amount = $final_amount;
                $trasnaction->e_charges = $transfer_charges;
                $trasnaction->trx_date = date("Y/m/d");
                $trasnaction->trx_time = date("h:i:s");
                $trasnaction->enkPay_Cashout_profit = 15;
                $trasnaction->receiver_name = $destinationAccountName;
                $trasnaction->receiver_account_no = $destinationAccountNumber;
                $trasnaction->balance = $debit;
                $trasnaction->status = 1;
                $trasnaction->save();

                $message1 = "NGN $amount_to_send - Just left your VFD Virtual Account";
                send_notification($message1);

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
        }


        if ($set->bank == 'manuel') {

            $erran_api_key = errand_api_key();

            $epkey = env('EPKEY');

            $final_amount = $request->final_amount;
            $destinationAccountNumber = Auth::user()->c_account_number;
            $destinationBankCode = Auth::user()->c_bank_code;

            $bank_name = VfdBank::select('bankName')->where('code', $destinationBankCode)->first()->bankName;
            $destinationAccountName = Auth::user()->c_account_name;

            $get_description = "Withdraw to Cashout Bank Account";
            $pin = $request->pin;

            $referenceCode = "ENK-" . random_int(1000000, 999999999);

            $transfer_charges = Charge::where('id', 1)->first()->amount;

            $description = $get_description;

            $user_balance = User::where('id', Auth::id())
                ->first()->main_wallet;

            $t_charges = Charge::where('id', 1)
                ->first()->amount;

            if ($final_amount > $user_balance) {

                return redirect('bank-transfer')->with('error', 'Insufficient Funds');
            }

            if ($final_amount < 100) {

                return back()->with('error', 'Amount must not be less than NGN 100');
            }

            if ($final_amount > 250025) {

                return back()->with('error', 'Amount can not be more than NGN 250,000.00');
            }

            //Debit
            $debit = $user_balance - $final_amount;

            $update = User::where('id', Auth::id())
                ->update([
                    'main_wallet' => $debit,
                ]);

            $amount_to_send = $final_amount - $t_charges;





            $trans_id = "ENK-" . random_int(100000, 999999);
            $status = 200;

            if ($status == 200) {

                //update Transactions
                $trasnaction = new Transaction();
                $trasnaction->user_id = Auth::id();
                $trasnaction->ref_trans_id = $trans_id;
                $trasnaction->type = "InterBankTransfer";
                $trasnaction->main_type = "Transfer";
                $trasnaction->transaction_type = "BankTransfer";
                $trasnaction->debit = $amount_to_send;
                $trasnaction->note = "Bank Transfer to other banks";
                $trasnaction->fee = 0;
                $trasnaction->amount = $final_amount;
                $trasnaction->e_charges = $transfer_charges;
                $trasnaction->enkPay_Cashout_profit = 15;
                $trasnaction->receiver_name = $destinationAccountName;
                $trasnaction->receiver_account_no = $destinationAccountNumber;
                $trasnaction->receiver_bank = $bank_name;
                $trasnaction->balance = $debit;
                $trasnaction->status = 1;
                $trasnaction->save();


                $trasnaction = new Transfer();
                $trasnaction->user_id = Auth::id();
                $trasnaction->ref_trans_id = $trans_id;
                $trasnaction->type = "InterBankTransfer";
                $trasnaction->main_type = "Transfer";
                $trasnaction->transaction_type = "BankTransfer";
                $trasnaction->debit = $amount_to_send;
                $trasnaction->note = "Bank Transfer to other banks";
                $trasnaction->fee = 0;
                $trasnaction->amount = $final_amount;
                $trasnaction->e_charges = $transfer_charges;
                $trasnaction->enkPay_Cashout_profit = 15;
                $trasnaction->receiver_name = $destinationAccountName;
                $trasnaction->receiver_account_no = $destinationAccountNumber;
                $trasnaction->receiver_bank = $bank_name;
                $trasnaction->balance = $debit;
                $trasnaction->status = 1;
                $trasnaction->save();

                $ip = $request->ip();
                $message = "Request to transfer $amount_to_send | $destinationAccountName | $bank_name | $destinationAccountNumber ";
                $result = "Message========> " . $message . "\n\nIP========> " . $ip;
                send_notification($result);


                $message1 = "NGN $amount_to_send - Just left your VFD Virtual Account";
                send_notification($message1);

                return redirect('bank-transfer')->with('message', 'Transaction Successful');
            } else {

                //credit
                $credit = $user_balance + $final_amount - $final_amount;

                $update = User::where('id', Auth::id())
                    ->update([
                        'main_wallet' => $credit,
                    ]);

                return redirect('bank-transfer')->with('error', 'Transaction failed, please try again later');
            }
        }

        // } catch (\Exception$th) {
        //     return $th->getMessage();
        // }
    }

    public function update_bank_info()
    {

        //$erran_api_key = errand_api_key();

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

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.errandpay.com/epagentservice/api/v1/ApiGetBanks',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                // "Authorization: Bearer $errand_key",
            ),
        ));

        $var = curl_exec($curl);

        curl_close($curl);
        $var = json_decode($var);

        $result = $var->data ?? null;

        if ($var->code == null) {

            return back()->with('error', 'Network issue, please try again later');
        }

        if ($var->code == 200) {

            $banks = $result;
        } else {
            return response()->json([

                'error' => 'Could not fetch banks',

            ]);
        }

        return view('update-bank-info', compact('user_balance', 'transaction', 'bank_name', 'account_number', 'account_name', 't_charges', 'banks'));
    }

    public function verify_info(request $request)
    {

        try {

            $user_balance = User::where('id', Auth::id())
                ->first()->main_wallet;

            $bank_data = $request->bank_code;
            $bank_name = preg_replace('/[0-9]+/', '', $bank_data);
            $account_number = $request->account_number;
            $bank_code = preg_replace('~\D~', '', $bank_data);

            $databody = array(

                'accountNumber' => $account_number,
                'institutionCode' => $bank_code,
                'channel' => "Bank",

            );

            $body = json_encode($databody);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://stagingapi.errandpay.com/epagentservice/api/v1/AccountNameVerification',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                ),
            ));

            $var = curl_exec($curl);
            curl_close($curl);
            $var = json_decode($var);

            $name = $var->data->name ?? null;

            $status = $var->code ?? null;

            $message = $var->error->message;

            if ($status == 200) {

                return view('update-bank-info-preview', compact('name', 'user_balance', 'bank_code', 'bank_name', 'account_number'));
            } else {

                return back('error', "$message");
            }
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function save_info(request $request)
    {

        $pin = $request->pin;
        $c_bank_name = $request->c_bank_name;
        $c_bank_code = $request->c_bank_code;
        $c_account_number = $request->c_account_number;
        $c_account_name = $request->c_account_name;

        $user_pin = User::where('id', Auth::id())
            ->first()->pin;

        if (Hash::check($pin, $user_pin) == false) {

            return redirect('update-bank')->with('error', 'Invalid Pin');
        }

        dd($request->all());
    }

    public function pos_terminal_view(request $request)
    {

        $terminal = Terminal::where('user_id', Auth::id())
            ->get();

        $terminal_count = Terminal::where('user_id', Auth::id())
            ->count();

        return view('pos-terminal', compact('terminal', 'terminal_count'));
    }

    public function pos_details_view(request $request)
    {


        $money_in = Transaction::where('serial_no', $request->serial_no)
            ->sum('credit');

        $money_week = Transaction::where('serial_no',  $request->serial_no)

            ->whereBetween(
                'created_at',
                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
            )
            ->get()->sum('credit');


        $transaction = Transaction::latest()->where('serial_no', $request->serial_no)
            ->paginate('10');


        $pos_transaction = Transaction::latest()->where([

            'serial_no' => $request->serial_no,
            'transaction_type' => 'CashOut'


        ])->paginate('10');


        $transfer_transaction = Transaction::latest()->where([
            'serial_no' => $request->serial_no,
            'transaction_type' => 'VirtualFundWallet'
        ])->paginate('10');





        return view('pos-details', compact('transfer_transaction', 'money_week', 'pos_transaction', 'transaction', 'money_in'));
    }
}
