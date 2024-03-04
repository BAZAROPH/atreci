<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class Celestadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if (auth()->user()) {
            $user_role = User::with('roles')
            ->get()
            ->find(auth()->user()->id);
            //dd($user_role->toArray());
            //if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin')) {
            if (count($user_role->roles) > 0) {
                if($user_role->roles[0]->name == 'superadmin' or $user_role->roles[0]->name == 'admin') {
                    return $next($request);
                }
            }
            else {
                flash("Bienvenue dans votre espace membre")->success();
                return redirect('/profil');
            }

        }
        flash("Bienvenue dans votre espace membre")->success();
        return redirect('/celestadmin');
    }
}
