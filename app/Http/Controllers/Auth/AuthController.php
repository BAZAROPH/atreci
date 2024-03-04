<?php
namespace App\Http\Controllers\Auth;

use App\Commande;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\InscriptionMail;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;

//use App\Mail\InscriptionMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        if (request('error') == "access_denied") {
            return redirect('/');
            flash('<strong>'.request('error_description').'</strong>!')->error();
        }
        $social = Socialite::driver($provider)->user();

        if(empty($social->email)){
            $user = User::where('provider_id', $social->id)->first();
        }
        else{
            $user = User::where('email', $social->email)->first();
        }
        if (!is_null($user)){
            auth()->login($user, true);
            auth()->user()->update([
                'provider' => $provider,
                'provider_id' => $social->id
            ]);
            flash('Hey <strong>'.$user->name.'</strong>! Bienvenue')->success();
        }else{
            $user = User::create([
                'name' => $social->name,
                'email' => $social->email,
                'provider' => $provider,
                'provider_id' => $social->id,
            ]);
            $user->assignRole('detaillant');
            auth()->login($user, true);  // Je connecte l'utilisateur

            if($social->avatar)
            {
                $user
                ->addMediaFromUrl($social->avatar)
                ->toMediaCollection('image');
            }
            //return redirect('account/password')->with("royal", "Bienvenue $user->name, votre compte a bien été crée! Nous vous conseillons de choisir un mot de passe afin de sécuriser votre compte");
            if (filter_var($user->email, FILTER_VALIDATE_EMAIL)){
                Mail::to($user->email)->send(new InscriptionMail($user));
            }
            Mail::to('developpeur@qenium.com')->send(new InscriptionMail($user));
            flash('Hey <strong>'.$social->name.'</strong>! Bienvenue')->success();
        }
        $commande = panierCommande('reference', Cookie::get('invATR'), $user);
        return redirect('/profil');
    }
}
