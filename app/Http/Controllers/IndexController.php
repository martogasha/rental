<?php

namespace App\Http\Controllers;

use App\Mail\Invoice;
use App\Models\Customer;
use App\Models\House;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function index(){
        return view('welcome');
    }
    public function property(){
        $props = Property::latest('id')->get();
        return view('property',[
            'props'=>$props
        ]);
    }
    public function billing(){
        $props = Lease::all();
        return view('customers',[
            'props'=>$props
        ]);
    }
    public function editProperty( Request $request){
        if ($request->ajax()) {
            $output = "";
            $order = Property::find($request->order);
                $output .= '
<input type="hidden" value="'.$order->id.'" name="id">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit '.$order->name.'</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">

                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-default" value="'.$order->name.'" name="name" placeholder="PROPERTY NAME">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-default" value="'.$order->location.'" name="location" placeholder="PROPERTY LOCATION">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                ';

        }
        return response($output);

    }
    public function editHouse( Request $request){
        if ($request->ajax()) {
            $output = "";
            $order = House::find($request->order);
                $output .= '
<input type="hidden" value="'.$order->id.'" name="id">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit '.$order->name.'</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">

                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-default" value="'.$order->name.'" name="name" placeholder="HOUSE NAME">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-default" value="'.$order->number.'" name="number" placeholder="HOUSE NUMBER">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-default" value="'.$order->status.'" name="status" placeholder="HOUSE STATUS">
                                                    </div>
                                                     <div class="form-group">
                                                        <input type="text" class="form-control input-default" value="'.$order->amount.'" name="amount" placeholder="HOUSE STATUS">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                ';

        }
        return response($output);

    }
    public function viewHouses( Request $request){
        if ($request->ajax()) {
            $output = "";
            $orders = House::where('property_id',$request->order)->get();
            foreach ($orders as $order) {
                $output .= '

                 <option value="'.$order->id.'">'.$order->name.' '.$order->number.'</option>



';
            }

        }
        return response($output);

    }
    public function houses($id){
        $prop = Property::find($id);
        $houses = House::where('property_id',$id)->get();
        return view('houses',[
            'prop'=>$prop,
            'houses'=>$houses
        ]);
    }
    public function eProperty(Request $request){
        $edit = Property::find($request->id);
        $edit->name = $request->input('name');
        $edit->location = $request->input('location');
            $edit->save();
        return redirect()->back()->with('success','PROPERTY EDITED SUCCESS');
    }
    public function ehouse(Request $request){
        $edit = House::find($request->id);
        $edit->name = $request->input('name');
        $edit->number = $request->input('number');
        $edit->amount = $request->input('amount');
            $edit->save();
        return redirect()->back()->with('success','HOUSE EDITED SUCCESS');
    }
    public function transaction(){
        $props = Transaction::all();
        return view('transactions',[
            'props'=>$props
        ]);
    }
    public function storeProperty(Request $request){
        $store = Property::create([
            'name'=>$request->input('name'),
            'location'=>$request->input('location')
        ]);
        return redirect()->back()->with('success','PROPERTY ADDED SUCCESS');
    }
    public function storeHouse(Request $request){
        $store = House::create([
            'name'=>$request->input('name'),
            'number'=>$request->input('number'),
            'amount'=>$request->input('amount'),
            'property_id'=>$request->input('property_id'),
            'status'=>$request->input('status')
        ]);
        return redirect()->back()->with('success','HOUSE ADDED SUCCESS');
    }
    public function storeLease(Request $request){
        $customer = Customer::create([
            'name'=>$request->input('customer_name'),
            'phone'=>$request->input('customer_phone'),
            'email'=>$request->input('customer_email'),
        ]);
        $lease = Lease::create([
            'customer_id'=>$customer->id,
            'house_id'=>$request->house_id,
            'balance'=>$request->input('amount'),
        ]);
        $invoice = \App\Models\Invoice::create([
            'lease_id'=>$lease->id,
            'date'=>Carbon::now()->format('d/m/Y'),
        ]);
        $type = Type::create([
           'type'=>'Lease Agreement',
           'amount'=>$request->input('amount'),
           'invoice_id'=>$invoice->id,
            'date'=>Carbon::now()->format('d/m/Y'),
        ]);
        $customer = \App\Models\Invoice::find($invoice->id);
        $pay = Lease::where('id',$invoice->lease_id)->first();
        $total = Type::where('invoice_id',$invoice->id)->sum('amount');
        $invoices = Type::where('invoice_id',$invoice->id)->get();
        $payments = Payment::where('invoice_id',$invoice->id)->get();
        Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));
        $updateHouse = House::where('id',$request->house_id)->update(['status'=>('OCCUPIED')]);

        return redirect(url('lease'))->with('success','LEASE CREATED SUCCESS');
    }
    public function lease(){
        $props = Lease::all();
        return view('lease',[
            'props'=>$props
        ]);
    }
    public function addLease($id){
        $prop = House::find($id);
        return view('addLease',[
            'prop'=>$prop
        ]);
    }
    public function storeBill(Request $request){
            $customer = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->first();

        if ($request->input('expense_type')=='Rent'){
            $getInv = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->first();
            if ($getInv){
                $type = Type::create([
                    'type'=>'Rent',
                    'amount'=>$request->input('amount'),
                    'invoice_id'=>$getInv->id,
                    'date'=>Carbon::now()->format('d/m/Y'),
                ]);
                $getBal = Lease::where('id',$request->input('lease_id'))->first();
                $bal = $getBal->balance;
                $currentBal = $bal + $request->input('amount');
                $updateBalance = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                $pay = Lease::where('id',$request->input('lease_id'))->first();
                $total = Type::where('invoice_id',$getInv->id)->sum('amount');
                $invoices = Type::where('invoice_id',$getInv->id)->get();
                $payments = Payment::where('invoice_id',$getInv->id)->get();
                Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));
            }
            else{
                $invoice = \App\Models\Invoice::create([
                    'lease_id'=>$request->input('lease_id'),
                    'date'=>Carbon::now()->format('d/m/Y'),
                ]);
                $getBal = Lease::where('id',$request->input('lease_id'))->first();
                $bal = $getBal->balance;
                $currentBal = $bal + $request->input('amount');
                $type = Type::create([
                    'type'=>'Rent',
                    'amount'=>$currentBal*-1,
                    'invoice_id'=>$invoice->id,
                    'date'=>Carbon::now()->format('d/m/Y'),
                ]);
                if ($bal<0){
                    $overdraft = $bal*-1;
                    $tranaction = Transaction::create([
                        'name'=>'overdraft',
                        'amount'=>$overdraft,
                        'payment_method'=>'Overdraft',
                        'bank_type'=>'Overdraft',
                        'date'=>Carbon::now()->format('d/m/Y'),
                    ]);
                    $getInvoice = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->first();
                    $payment = Payment::create([
                        'transaction_id'=> $tranaction->id,
                        'invoice_id'=> $getInvoice->id,
                        'date'=>Carbon::now()->format('d/m/Y'),
                    ]);
                    $updateBal = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                    if ($currentBal<='0'){
                        $updateInvoice = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->update(['status'=>'1']);

                    }
                    $customer = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->first();

                    $pay = Lease::where('id',$request->input('lease_id'))->first();
                    $total = Type::where('invoice_id',$getInvoice->id)->sum('amount');
                    $invoices = Type::where('invoice_id',$getInvoice->id)->get();
                    $payments = Payment::where('invoice_id',$getInvoice->id)->get();
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));

                }
                else{
                    $updateBalance = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                    $pay = Lease::where('id',$request->input('lease_id'))->first();
                    $total = Type::where('id',$type->id)->sum('amount');
                    $invoices = Type::where('invoice_id',$invoice->id)->get();
                    $payments = Payment::where('invoice_id',$invoice->id)->get();
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));
                }

            }

        }
        elseif($request->input('expense_type')=='Water'){
            $getInv = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->first();
            if ($getInv){
                $type = Type::create([
                    'type'=>'Water',
                    'amount'=>$request->input('enter_amount'),
                    'invoice_id'=>$getInv->id,
                    'date'=>Carbon::now()->format('d/m/Y'),
                ]);
                $getBal = Lease::where('id',$request->input('lease_id'))->first();
                $bal = $getBal->balance;
                $currentBal = $bal + $request->input('enter_amount');
                $updateBalance = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                $pay = Lease::where('id',$request->input('lease_id'))->first();
                $total = Type::where('invoice_id',$getInv->id)->sum('amount');
                $invoices = Type::where('invoice_id',$getInv->id)->get();
                $payments = Payment::where('invoice_id',$getInv->id)->get();
                Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));
            }
            else{
                $invoice = \App\Models\Invoice::create([
                    'lease_id'=>$request->input('lease_id'),
                    'date'=>Carbon::now()->format('d/m/Y'),
                ]);
                $getBal = Lease::where('id',$request->input('lease_id'))->first();
                $bal = $getBal->balance;
                $currentBal = $bal + $request->input('enter_amount');
                $type = Type::create([
                    'type'=>'Water',
                    'amount'=>$request->input('enter_amount'),
                    'invoice_id'=>$invoice->id,
                    'date'=>Carbon::now()->format('d/m/Y'),
                ]);
                if ($bal<0){
                    $overdraft = $bal*-1;
                    $tranaction = Transaction::create([
                        'name'=>'overdraft',
                        'amount'=>$overdraft,
                        'payment_method'=>'Overdraft',
                        'bank_type'=>'Overdraft',
                        'date'=>Carbon::now()->format('d/m/Y'),
                    ]);
                    $getInvoice = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->first();
                    $payment = Payment::create([
                        'transaction_id'=> $tranaction->id,
                        'invoice_id'=> $getInvoice->id,
                        'date'=>Carbon::now()->format('d/m/Y'),
                    ]);
                    $updateBal = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                    if ($currentBal<='0'){
                        $updateInvoice = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->update(['status'=>'1']);

                    }
                    $customer = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->first();

                    $pay = Lease::where('id',$request->input('lease_id'))->first();
                    $total = Type::where('invoice_id',$getInvoice->id)->sum('amount');
                    $invoices = Type::where('invoice_id',$getInvoice->id)->get();
                    $payments = Payment::where('invoice_id',$getInvoice->id)->get();
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));

                }
                else{
                    $updateBalance = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                    $pay = Lease::where('id',$request->input('lease_id'))->first();
                    $total = Type::where('id',$type->id)->sum('amount');
                    $invoices = Type::where('invoice_id',$invoice->id)->get();
                    $payments = Payment::where('invoice_id',$invoice->id)->get();
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));
                }

            }
        }
        else{
            $getInv = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->first();
            if ($getInv){
                $type = Type::create([
                    'type'=>'Garbage',
                    'amount'=>$request->input('enter_amount'),
                    'invoice_id'=>$getInv->id,
                    'date'=>Carbon::now()->format('d/m/Y'),
                ]);
                $getBal = Lease::where('id',$request->input('lease_id'))->first();
                $bal = $getBal->balance;
                $currentBal = $bal + $request->input('enter_amount');
                $updateBalance = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                $pay = Lease::where('id',$request->input('lease_id'))->first();
                $total = Type::where('invoice_id',$getInv->id)->sum('amount');
                $invoices = Type::where('invoice_id',$getInv->id)->get();
                $payments = Payment::where('invoice_id',$getInv->id)->get();
                Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));
            }
            else{
                $invoice = \App\Models\Invoice::create([
                    'lease_id'=>$request->input('lease_id'),
                    'date'=>Carbon::now()->format('d/m/Y'),
                ]);
                $getBal = Lease::where('id',$request->input('lease_id'))->first();
                $bal = $getBal->balance;
                $currentBal = $bal + $request->input('enter_amount');
                $type = Type::create([
                    'type'=>'Garbage',
                    'amount'=>$request->input('enter_amount'),
                    'invoice_id'=>$invoice->id,
                    'date'=>Carbon::now()->format('d/m/Y'),
                ]);
                if ($bal<0){
                    $overdraft = $bal*-1;
                    $tranaction = Transaction::create([
                        'name'=>'overdraft',
                        'amount'=>$overdraft,
                        'payment_method'=>'Overdraft',
                        'bank_type'=>'Overdraft',
                        'date'=>Carbon::now()->format('d/m/Y'),
                    ]);
                    $getInvoice = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->first();
                    $payment = Payment::create([
                        'transaction_id'=> $tranaction->id,
                        'invoice_id'=> $getInvoice->id,
                        'date'=>Carbon::now()->format('d/m/Y'),
                    ]);
                    $updateBal = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                    if ($currentBal<='0'){
                        $updateInvoice = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->update(['status'=>'1']);

                    }
                    $customer = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->first();

                    $pay = Lease::where('id',$request->input('lease_id'))->first();
                    $total = Type::where('invoice_id',$getInvoice->id)->sum('amount');
                    $invoices = Type::where('invoice_id',$getInvoice->id)->get();
                    $payments = Payment::where('invoice_id',$getInvoice->id)->get();
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));

                }
                else{
                    $updateBalance = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                    $pay = Lease::where('id',$request->input('lease_id'))->first();
                    $total = Type::where('id',$type->id)->sum('amount');
                    $invoices = Type::where('invoice_id',$invoice->id)->get();
                    $payments = Payment::where('invoice_id',$invoice->id)->get();
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));
                }

            }
        }
        return redirect()->back()->with('success','INVOICED SUCCESSFULLY');

    }
    public function storeTransaction(Request $request){
        $tranaction = Transaction::create([
            'ref'=>$request->input('ref_no'),
            'name'=>$request->input('name'),
            'amount'=>$request->input('amount'),
            'payment_method'=>$request->input('payment_type'),
            'bank_type'=>$request->input('bank_type'),
            'date'=>Carbon::now()->format('d/m/Y'),
        ]);
        $getInvoice = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->first();
        if ($getInvoice){
            $payment = Payment::create([
                'transaction_id'=> $tranaction->id,
                'invoice_id'=> $getInvoice->id,
            ]);
            $getCurrentBalance = Lease::find($request->input('lease_id'));
            $bal = $getCurrentBalance->balance;
            $amount = $request->input('amount');
            $currentBal = $bal-$amount;
            $updateBal = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
            if ($currentBal<='0'){
                $updateInvoice = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->update(['status'=>'1']);

            }

            $customer = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->first();

            $pay = Lease::where('id',$request->input('lease_id'))->first();
            $total = Type::where('invoice_id',$getInvoice->id)->sum('amount');
            $invoices = Type::where('invoice_id',$getInvoice->id)->get();
            $payments = Payment::where('invoice_id',$getInvoice->id)->get();
            Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));
            return redirect()->back()->with('success','TRANSACTION SAVED SUCCESSFULLY');
        }
        else{
            $getLease = Lease::find($request->input('lease_id'));
            $bal = $getLease->balance;
            $amount = $request->input('amount');
            $currentBal = $bal-$amount;
            $updateBal = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
            $invoice = \App\Models\Invoice::create([
                'lease_id'=>$request->input('lease_id'),
                'date'=>Carbon::now()->format('d/m/Y'),
            ]);
            $type = Type::create([
                'type'=>'Overdraft',
                'amount'=>$request->input('amount'),
                'invoice_id'=>$invoice->id,
                'date'=>Carbon::now()->format('d/m/Y'),
            ]);
            $payment = Payment::create([
                'transaction_id'=> $tranaction->id,
                'invoice_id'=> $invoice->id,
            ]);
            $customer = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->first();
            $getInvoice = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','0')->update(['status'=>'1']);
            $getInv = \App\Models\Invoice::where('lease_id',$request->input('lease_id'))->where('status','1')->latest()->first();
            $pay = Lease::where('id',$request->input('lease_id'))->first();
            $total = Type::where('invoice_id',$getInv->id)->sum('amount');
            $invoices = Type::where('invoice_id',$getInv->id)->get();
            $payments = Payment::where('invoice_id',$getInv->id)->get();
            Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments));
            return redirect()->back()->with('success','TRANSACTION SAVED SUCCESSFULLY');


        }

    }
}
