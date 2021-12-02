<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistroEmpresaria extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Registro en Ibizza';

    public $correo,$contraseña;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($informacion_registro,$contraseña)
    {
        $this->correo = $informacion_registro['email'];
        $this->contraseña = $contraseña;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('email.registro');
    }
}
