<?php

namespace App\Http\Controllers;

use App\Cat;
use App\Mail\Invoice;
use App\Models\Customer;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Type;
use App\Mpesa;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Kopokopo\SDK\K2;
use Session;

class MpesaController extends Controller
{
    public function subscribe(){
        $options = [
            'clientId' => 'J6IUCHendZ4SbNEAF6WWJZIFcKR2LCmy5hmrlkIVHcU',
            'clientSecret' => 'IDbzppyG-fXTgClVemBnh2irjcfUG_s8E4AD3xELMO4',
            'apiKey' => 'a3ee4134cc102a400aef96c3c9d1a635829f54d2',
            'baseUrl' => 'https://api.kopokopo.com'
        ];
        $K2 = new K2($options);
        $tokens = $K2->TokenService();
        $result = $tokens->getToken();
        $access = $result['data'];
        $accessToken = $access['accessToken'];
        $webhooks = $K2->Webhooks();
        $response = $webhooks->subscribe([
            'eventType' => 'buygoods_transaction_received',
            'url' => 'https://rental.iconztech.com/api/storeWebhooks',
            'scope' => 'till',
            'scopeReference' => '000798',
            'accessToken' => $accessToken,
        ]);
        $location = $response['location'];
        $stk = $K2->StkService();
        $options = [
            'location' => $location,
            'accessToken' => $accessToken,
        ];
        $response = $stk->getStatus($options);
        dd($response);
    }
    public function storeWebhooks(Request $request){
        $input = $request->json()->all();
        $firstName = $input['event']['resource']['sender_first_name'];
        $firstMiddle = $input['event']['resource']['sender_middle_name'];
        $firstLast = $input['event']['resource']['sender_last_name'];
        $tranaction = Transaction::create([
            'ref'=>$input['event']['resource']['reference'],
            'name'=>($firstName ."". $firstMiddle ."". $firstLast),
            'amount'=>$input['event']['resource']['amount'],
            'payment_method'=>'Mpesa',
            'bank_type'=>'Mpesa',
            'date'=>Carbon::now()->format('d/m/Y'),
        ]);
        $getUser = Customer::where('phone',$input['event']['resource']['sender_phone_number'])->first();
        $getLease = Lease::where('customer_id',$getUser->id)->first();
        $getInvoice = \App\Models\Invoice::where('lease_id',$getLease->id)->where('status','0')->first();
        $payment = Payment::create([
            'transaction_id'=> $tranaction->id,
            'invoice_id'=> $getInvoice->id,
        ]);
        $getCurrentBalance = Lease::find($getLease->id);
        $bal = $getCurrentBalance->balance;
        $amount = $tranaction->amount;
        $currentBal = $bal-$amount;
        $updateBal = Lease::where('id',$getLease->id)->update(['balance'=>$currentBal]);
        $updateInvoice = \App\Models\Invoice::where('lease_id',$getLease->id)->where('status','0')->update(['status'=>'1']);

        $customer = \App\Models\Invoice::where('lease_id',$getLease->id)->first();

        $pay = Payment::where('invoice_id',$getInvoice->id)->first();
        $total = Type::where('invoice_id',$getInvoice->id)->sum('amount');
        $invoices = Type::where('invoice_id',$getInvoice->id)->get();
        $payments = Payment::where('invoice_id',$getInvoice->id)->get();
        Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));
    }
    public function authenticate(){
        global $K2;
        global $response;
        $webhooks = $K2->Webhooks();

        $json_str = file_get_contents('https://rental.iconztech.com/api/storeWebhooks');
        $response = $webhooks->webhookHandler($json_str, $_SERVER['a419432d-284a-4688-9535-bcf7314c3639']);
        dd($response);
    }
    public function mpesaTransaction(){
        $transactions = Transaction::where('payment_method','Mpesa')->get();
        return view('mpesa',[
            'transactions'=>$transactions
        ]);
    }
    public function bankTransaction(){
        $transactions = Transaction::where('payment_method','BANK')->get();
        return view('bank',[
            'transactions'=>$transactions
        ]);
    }
    public function chequeTransaction(){
        $transactions = Transaction::where('payment_method','CHEQUE ')->get();
        return view('cheques',[
            'transactions'=>$transactions
        ]);
    }
    public function customer($id){
        $invoices = Invoice::where('lease_id',$id)->where('status',0)->get();
        $invoice = Invoice::where('lease_id',$id)->first();
        $lease = Lease::find($id);
        return view('cDetails',[
            'invoices'=>$invoices,
            'invoice'=>$invoice,
            'lease'=>$lease
        ]);
    }
    public function customerPaid($id){
        $invoices = Invoice::where('lease_id',$id)->where('status','1')->get();
        $invoice = Invoice::where('lease_id',$id)->first();
        $lease = Lease::find($id);
        return view('cDetailsPaid',[
            'invoices'=>$invoices,
            'invoice'=>$invoice,
            'lease'=>$lease
        ]);
    }
    public function invoice($id){
        $invoices = Type::where('invoice_id',$id)->get();
        $total = Type::where('invoice_id',$id)->sum('amount');
        $customer = Invoice::where('id',$id)->where('status',0)->first();
        $payments = Payment::where('invoice_id',$id)->get();
        $pay = Payment::where('invoice_id',$id)->first();
        return view('invoice',[
            'invoices'=>$invoices,
            'total'=>$total,
            'customer'=>$customer,
            'payments'=>$payments,
            'pay'=>$pay
        ]);
    }
    public function invoicePaid($id){
        $invoices = Type::where('invoice_id',$id)->get();
        $total = Type::where('invoice_id',$id)->sum('amount');
        $customer = Invoice::where('id',$id)->first();
        $payments = Payment::where('invoice_id',$id)->get();
        $pay = Payment::where('invoice_id',$customer->id)->first();
        return view('invoice',[
            'invoices'=>$invoices,
            'total'=>$total,
            'customer'=>$customer,
            'payments'=>$payments,
            'pay'=>$pay
        ]);
    }
    public function paidInvoice(){
        return view('paidInvoice');
    }
}
