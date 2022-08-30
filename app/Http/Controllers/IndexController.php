<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\House;
use App\Models\Lease;
use App\Models\Property;
use App\Models\Transaction;
use Illuminate\Http\Request;

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
    public function customers(){
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
        ]);
        $transaction = Transaction::create([
            'ref'=>$request->input('ref'),
            'amount'=>$request->input('amount'),
            'payment_method'=>$request->input('payment_method'),
            'phone'=>$request->input('customer_phone'),
        ]);

        $lease = Lease::create([
            'customer_id'=>$customer->id,
            'house_id'=>$request->house_id,
            'transaction_id'=>$transaction->id,
        ]);
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
}
