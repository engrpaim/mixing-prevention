<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $userIp = DB::table('admin_models')
        ->where('ip','=',request()->ip())
        ->first();
        if($userIp){

            $model = $userIp->model ;
            $view = $userIp->view ;
            $manage = $userIp->manage ;
            $admin = $userIp->admin ;

        }else{
            $model = 'OFF' ;
            $view = 'OFF'  ;
            $manage = 'OFF'  ;
            $admin = 'OFF'  ;
        }

        // dump($model,$view,$manage,  $admin );
        View::share([
                        'clientIp' => request()->ip(),
                        'model' => $model,
                        'view' => $view,
                        'manage' => $manage,
                        'admin' => $admin,
                    ]);

    }
}
