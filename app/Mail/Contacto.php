<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contacto extends Mailable
{
    use Queueable, SerializesModels;

    public $name,$email,$phonenumber,$comments;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos)
    {
        $this->name = $datos['firstname'].' '.$datos['lastname'];
        $this->email = $datos['email'];
        $this->phonenumber = $datos['phonenumber'];
        $this->comments = $datos['comments'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email, $this->name)->subject('Formulario de contacto')->view('email.contacto');
    }
}
