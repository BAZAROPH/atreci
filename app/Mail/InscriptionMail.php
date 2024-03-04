<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $suiveur;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($suiveur)
    {
        $this->suiveur = $suiveur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Bienvenue sur Atrê marché')
            ->markdown('mail.inscription');
    }
}
