<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        $parametre = parametre_web();
        // Journalisation
        activity()
            ->log('password-reset');
        // End journalisation
        return view('auth.passwords.email')->with([
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Réinitialisation du mot de passe',
                'slug' => 'password/reset',
            ),
        ]);
    }
}
