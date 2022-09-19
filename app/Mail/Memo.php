<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Memo extends Mailable
{
    use Queueable, SerializesModels;
    public $property;
    public $date;
    public $desc;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($property,$date,$desc)
    {
        $this->property=$property;
        $this->date=$date;
        $this->desc=$desc;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('maxmillankibe@gmail.com')->markdown('memo');
    }
}
