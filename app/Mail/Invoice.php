<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invoice extends Mailable
{
    use Queueable, SerializesModels;
    public $customer;
    public $pay;
    public $total;
    public $invoices;
    public $payments;
    public $paying;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer,$pay,$total,$invoices,$payments,$paying)
    {
        $this->customer=$customer;
        $this->pay=$pay;
        $this->total=$total;
        $this->invoices=$invoices;
        $this->payments=$payments;
        $this->paying=$paying;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('maxmillankibe@gmail.com')->markdown('invoice');
    }
}
