<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Login(){
        return view('auth.login');
    }
    public function log(Request $request){
        $user = User::where('email',$request->email)->first();
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])){
            return redirect(url('Dashboard'));
        }
        else{
            return redirect()->back()->with('error', 'CREDENTIALS DOES NOT MATCH');
        }
    }
    public function addUser(Request $request){
        $user = User::create([
           'name'=>$request->input('name'),
           'email'=>$request->input('email'),
           'role'=>$request->input('role'),
           'check_one'=>$request->input('customCheckBox1'),
           'check_two'=>$request->input('customCheckBox2'),
           'check_three'=>$request->input('customCheckBox3'),
           'check_four'=>$request->input('customCheckBox4'),
           'check_five'=>$request->input('customCheckBox5'),
           'check_six'=>$request->input('customCheckBox6'),
           'check_seven'=>$request->input('customCheckBox7'),
           'password'=>Hash::make('password'),
        ]);
        return redirect()->back()->with('success','USER ADDED SUCCESS');
    }
    public function editRole($id){
        $user = User::find($id);
        return view('editRole',[
            'user'=>$user
        ]);
    }
    public function eUser(Request $request){
        $edit = User::find($request->user_id);
        $edit->name = $request->input('name');
        $edit->email = $request->input('email');
        $edit->role = $request->input('role');
        $edit->check_one = $request->input('customCheckBox1');
        $edit->check_two = $request->input('customCheckBox2');
        $edit->check_three = $request->input('customCheckBox3');
        $edit->check_four = $request->input('customCheckBox4');
        $edit->check_five = $request->input('customCheckBox5');
        $edit->check_six = $request->input('customCheckBox6');
        $edit->check_seven = $request->input('customCheckBox7');
        $edit->password = Hash::make('password');
        $edit->save();
        return redirect(url('role'))->with('success','USER EDITED / PASSWORD RESET SUCCESS');
    }
    public function prof(Request $request){
        $user = User::find($request->user_id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect(url('Dashboard'))->with('success','PROFILE UPDATED SUCCESS');
    }
}
