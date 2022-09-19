<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Quote extends Mailable
{
    use Queueable, SerializesModels;
    public $house;
    public $amount;
    public $date;
    public $desc;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($house,$amount,$date,$desc,$name)
    {
        $this->house=$house;
        $this->amount=$amount;
        $this->date=$date;
        $this->desc=$desc;
        $this->name=$name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('maxmillankibe@gmail.com')->markdown('quotation');
    }
}
