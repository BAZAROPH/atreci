<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_TIME, 'fr_FR', 'fr', 'FR', 'French', 'fr_FR.UTF-8');
        Carbon::setLocale(config('app.locale'));


        Activity::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->put('agent', [
                'ip' => request()->ip(),
                'agent' => request()->header('User-Agent'),
                'url' => request()->fullUrl(),
            ]);
        });
    }
}
