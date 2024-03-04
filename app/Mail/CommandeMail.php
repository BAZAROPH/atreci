<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Detection\MobileDetect;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class CommandeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $commande;
    public $type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($commande, $type)
    {
        $this->commande = $commande;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type == 'administrateur') {
            $subject = 'Nouvelle commande ('.$this->commande->reference.') sur Atrê marché';
        }
        else{
            $subject = 'Votre commande '.$this->commande->reference.' a été confirmée';
        }
        return $this
        ->subject($subject)
        ->markdown('mail.commande');
    }
}
