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
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function index(){
        if (Auth::check()){
            return view('welcome');

        }
        else{
            return redirect(url('/'));
        }
    }
    public function profile(){
        return view('profile');
    }
    public function property(){
        $props = Property::where('status','0')->get();
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
    public function delProperty( Request $request){
        if ($request->ajax()) {
            $output = "";
            $order = Property::find($request->order);
                $output .= '
<input type="hidden" value="'.$order->id.'" name="id">
  <div class="modal-header">
                                            <h5 class="modal-title" style="color: red">ARE YOU SURE YO WANT TO DELETE<br> '.$order->name.'</h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                            </button>
                                        </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Delete</button>
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
    public function quoteHouse( Request $request){
        if ($request->ajax()) {
            $output = "";
            $order = House::find($request->order);
                $output .= '
<input type="hidden" value="'.$order->id.'" name="id">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Quote '.$order->name.'</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">

                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-default" value="'.$order->name.'">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-default" value="'.$order->number.'">
                                                    </div>

                                                     <div class="form-group">
                                                        <input type="text" class="form-control input-default" value="'.$order->amount.'" name="amount" placeholder="HOUSE STATUS">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-default" name="desc" placeholder="CUSTOM MESSAGE">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-default" name="name" placeholder="Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-default" name="email" placeholder="ENTER EMAIL ADDRESS">
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
    public function getMemo( Request $request){
        if ($request->ajax()) {
            $output = "";
            $order = Property::find($request->order);
                $output .= '
<input type="hidden" value="'.$order->id.'" name="id">
                                            <div class="modal-header">
                                                <h5 class="modal-title">MEMO FOR '.$order->name.'</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">


                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-default" name="desc" placeholder="CUSTOM MESSAGE">
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
    public function sendQuote(Request $request){
        $house = House::find($request->id);
        $amount = $request->amount;
        $date = Carbon::now()->format('d/m/Y');
        $desc = $request->desc;
        $name = $request->name;
        Mail::to($request->email)->send(new \App\Mail\Quote($house,$amount,$date,$desc,$name));
        return redirect()->back()->with('success','QUOTATION SENT SUCCESSFULLY');
    }
    public function memo(Request $request){

        $houses = House::where('property_id',$request->id)->get();
        foreach ($houses as $house){
            $property = Property::find($request->id);
            $desc = $request->desc;
            $date = Carbon::now()->format('d/m/Y');
            Mail::to($house->lease->customer->email)->send(new \App\Mail\Memo($property,$date,$desc));

        }

        return redirect()->back()->with('success','MEMO SENT SUCCESSFULLY');
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
        $getPhone = Customer::where('phone',$request->input('customer_phone'))->orWhere('email',$request->input('customer_email'))->first();
        if ($getPhone){
            if ($getPhone->phone==$request->input('customer_phone')){
                return redirect()->back()->with('error','DUPLICATE PHONE NUMBER');
            }
            elseif ($getPhone->email==$request->input('customer_email')){
                return redirect()->back()->with('error','DUPLICATE EMAIL ADDRESS');

            }
            else{

            }
        }

        else{
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
            $updateHouse = House::where('id',$request->house_id)->update(['status'=>('OCCUPIED')]);
            $updateLeaseId = House::where('id',$request->house_id)->update(['lease_id'=>$lease->id]);
            $customer = \App\Models\Invoice::find($invoice->id);
            $pay = Lease::where('id',$invoice->lease_id)->first();
            $total = Type::where('invoice_id',$invoice->id)->sum('amount');
            $invoices = Type::where('invoice_id',$invoice->id)->get();
            $payments = Payment::where('invoice_id',$invoice->id)->get();
            $paying = \App\Models\Invoice::find($invoice->id);
            Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));


            return redirect(url('lease'))->with('success','LEASE CREATED SUCCESS');
        }

    }
    public function lease(){
        $props = Lease::where('status','0')->get();
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
                $paying = \App\Models\Invoice::find($getInv->id);
                Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));
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
                    'amount'=>$getBal->house->amount,
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
                    $paying = \App\Models\Invoice::find($getInvoice->id);
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));

                }
                else{
                    $updateBalance = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                    $pay = Lease::where('id',$request->input('lease_id'))->first();
                    $total = Type::where('id',$type->id)->sum('amount');
                    $invoices = Type::where('invoice_id',$invoice->id)->get();
                    $payments = Payment::where('invoice_id',$invoice->id)->get();
                    $paying = \App\Models\Invoice::find($invoice->id);
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));
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
                $paying = \App\Models\Invoice::find($getInv->id);
                Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));
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
                    $paying = \App\Models\Invoice::find($getInvoice->id);
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));

                }
                else{
                    $updateBalance = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                    $pay = Lease::where('id',$request->input('lease_id'))->first();
                    $total = Type::where('id',$type->id)->sum('amount');
                    $invoices = Type::where('invoice_id',$invoice->id)->get();
                    $payments = Payment::where('invoice_id',$invoice->id)->get();
                    $paying = \App\Models\Invoice::find($invoice->id);
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));
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
                $paying = \App\Models\Invoice::find($getInv->id);
                Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));
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
                    $paying = \App\Models\Invoice::find($getInvoice->id);
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));

                }
                else{
                    $updateBalance = Lease::where('id',$request->input('lease_id'))->update(['balance'=>$currentBal]);
                    $pay = Lease::where('id',$request->input('lease_id'))->first();
                    $total = Type::where('id',$type->id)->sum('amount');
                    $invoices = Type::where('invoice_id',$invoice->id)->get();
                    $payments = Payment::where('invoice_id',$invoice->id)->get();
                    $paying = \App\Models\Invoice::find($invoice->id);
                    Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));
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
            $paying = \App\Models\Invoice::find($getInvoice->id);
            Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));
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
            $paying = \App\Models\Invoice::find($getInv->id);
            Mail::to($customer->lease->customer->email)->send(new Invoice($customer,$pay,$total,$invoices,$payments,$paying));
            return redirect()->back()->with('success','TRANSACTION SAVED SUCCESSFULLY');


        }

    }
    public function terminate(Request $request){
        $output = "";
        $getLease = Lease::find($request->order);
        $getBalance = $getLease->balance;
        $output = '
                                                        <div class="modal-header">
                                                    <h5 class="modal-title">Terminate Lease for <b style="color: red">'.$getLease->customer->name.'</b></h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                    </button>
                                                </div>
                                                <input type="hidden" value="'.$getLease->id.'" name="leaseId">
                                                <div class="card-body">
                                                    <p>ARE YOU SURE TERMINATION FOR <b>'.$getLease->customer->name.'</b></p>
                                                    <p>BALANCE: <b>'.$getBalance.'</b></p>
                                                    </div>
                                                </div>
        ';
        return response($output);

    }
    public function terminateLease(Request $request){
        $updateLease = Lease::where('id',$request->leaseId)->update(['status'=>'1']);
        $updateHouse = House::where('lease_id',$request->leaseId)->update(['status'=>'VACANT']);
        $updateLeaseId = House::where('lease_id',$request->leaseId)->update(['lease_id'=>null]);
        return redirect()->back()->with('success','LEASE TERMINATED SUCCESS');

    }
    public function terminated(){
        $props = Lease::where('status','1')->get();
        return view('terminated',[
            'props'=>$props
        ]);
    }
    public function role(){
        $users = User::all();
        return view('role',[
            'users'=>$users
        ]);
    }
    public function dProperty(Request $request){
        $deleteHouses = House::where('property_id',$request->id)->get();
        foreach ($deleteHouses as $deleteHouse){
            $updateLease = Lease::where('house_id',$deleteHouse->id)->update(['status'=>'1']);
        }
        $updateHouses = House::where('property_id',$request->id)->update(['status'=>'TERMINATED']);

        $del = Property::where('id',$request->id)->update(['status'=>'1']);

        return redirect()->back()->with('success','PROPERTY DELETED SUCCESS');
    }
}
