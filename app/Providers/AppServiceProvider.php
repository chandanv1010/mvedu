<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Carbon\Carbon;
use App\Http\ViewComposers\MenuComposer;
use App\Http\ViewComposers\CartComposer;
use App\Http\ViewComposers\CustomerComposer;
use App\Http\ViewComposers\SystemComposer;
use App\Models\Language;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        $locale = app()->getLocale(); // vn en cn
        $language = Language::where('canonical', $locale)->first();

        Validator::extend('custom_date_format', function($attribute, $value, $parameters, $validator){
            return Datetime::createFromFormat('d/m/Y H:i', $value) !== false;
        });

        Validator::extend('custom_after', function($attribute, $value, $parameters, $validator){
            $startDate = Carbon::createFromFormat('d/m/Y H:i', $validator->getData()[$parameters[0]]);
            $endDate = Carbon::createFromFormat('d/m/Y H:i', $value);
            
            return $endDate->greaterThan($startDate) !== false;
        });


        view()->composer(['frontend.*', 'mobile.*', 'errors.*'], function($view) use ($language){
            $composerClasses = [
                MenuComposer::class,
                CartComposer::class,
                CustomerComposer::class,
                SystemComposer::class,
            ];

            foreach($composerClasses as $key => $val){
                $composer = app()->make($val, ['language' => $language->id]);
                $composer->compose($view);
            }

            if (!$view->offsetExists('seo')) {
                $view->with('seo', [
                    'meta_title' => '404 - Trang không tìm thấy',
                    'meta_description' => '',
                    'meta_keyword' => '',
                    'meta_image' => '',
                    'canonical' => url()->current(),
                ]);
            }

            if (!$view->offsetExists('config')) {
                $view->with('config', [
                    'js' => [],
                    'css' => [],
                ]);
            }
        });


        Schema::defaultStringLength(191);
    }
}
