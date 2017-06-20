<?php

namespace App\Providers;

use Auth;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Facades\App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Laravel\Tinker\TinkerServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('user.profile.layout', function ($view) {
            $action = app('request')->route()->getAction();
            $controller = class_basename($action['controller']);

            list($_controller, $_action) = explode('@', $controller);

            $_filledProfile = UserService::getPercentageFilledAcc(Auth::user());

            $view->with(compact('_controller', '_action','_filledProfile'));
        });

        Validator::extend('required_or_closed', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            if ($parameters != null) {//separeted opening hours for days
                $index = $parameters[0];
                if ($data[ 'closed'.$index ] == 1) {
                    return true;
                } else {
                    return $value != null && preg_match('/^\d\d:\d\d$/', $value);
                }
            } else {//its grouped workdays input
                if ($data['workdays'] == 1) {
                    return true;
                } else {
                    return $value != null && preg_match('/^\d\d:\d\d$/', $value);
                }
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(IdeHelperServiceProvider::class);
        $this->app->register(TinkerServiceProvider::class);
    }
}
