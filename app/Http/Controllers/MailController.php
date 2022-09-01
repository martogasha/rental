<?php

namespace App\Http\Controllers;

use App\Mail\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(){
        $name = 'Maxmillan Kibe';
        Mail::to('kibemax2000@gmail.com')->send(new Invoice($name));
        return redirect(url('/'));

    }
}
