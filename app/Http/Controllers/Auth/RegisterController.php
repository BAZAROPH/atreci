<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\InscriptionMail;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Gloudemans\Shoppingcart\Facades\Cart;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function redirectTo()
    {
        if (count(Cart::instance('shopping')->content())){
            return '/adresse-de-livraison';
        }
        else {
            return RouteServiceProvider::HOME;
        }
    }

    public function showRegistrationForm()
    {
        $parametre = parametre_web();
        return view('auth.register')->with([
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Inscription',
                'slug' => 'register',
            ),
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            //'telephone' => ['nullable', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'min:4'],
            'g-recaptcha-response' => 'recaptcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //dd($data);
        $userActuelle = User::create([
            'name' => $data['name'],
            //'telephone' => $data['telephone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $userActuelle->assignRole('detaillant');

        $commande = panierCommande('reference', Cookie::get('invATR'), $userActuelle);
        //dd($commande->toArray());

        if(isset($data['email'])){
            Mail::to($data['email'])->send(new InscriptionMail($data));
        }
        Mail::to('developpeur@qenium.com')->send(new InscriptionMail($data));
        flash('Salut <strong>'.$data['name'].'</strong>! Bienvenue;-)')->success();
        return $userActuelle;
        //return redirect('/profil');
    }
}
