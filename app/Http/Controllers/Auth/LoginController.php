<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    //protected $redirectTo = 'adresse-de-livraison';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
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

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('email');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'matricule';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // Customization: Validate if client status is active (1)
        $email = $request->get($this->username());
        // Customization: It's assumed that email field should be an unique field
        $user = User::where($this->username(), $email)->first();
        //dd($client);
        $commande = panierCommande('reference', Cookie::get('invATR'), $user);

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function showLoginForm()
    {
        $parametre = parametre_web();
        // Journalisation
        activity()
            ->log('login');
        // End journalisation
        return view('auth.login')->with([
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Connexion',
                'slug' => 'login',
            ),
        ]);
    }
}
