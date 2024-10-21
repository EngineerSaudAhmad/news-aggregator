<?php

namespace App\Providers;

use App\Services\ArticleService;
use App\Services\AuthService;
use App\Services\Contracts\IArticleService;
use App\Services\Contracts\IAuthService;
use App\Services\Contracts\IUserPreferenceService;
use App\Services\UserPreferenceService;
use Illuminate\Support\ServiceProvider;


/**
 * Class AppServiceProvider
 *
 * @package   App\Providers
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 19, 2024
 * @project   news-aggregator
 */
class AppServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }//end register()


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bind service contracts and implementations.
        $this->bootServiceDependencies();
    }//end boot()


    /**
     * Function bootServiceDependencies
     *
     * @return void
     */
    public function bootServiceDependencies(): void
    {
        $this->app->singleton(IAuthService::class, AuthService::class);
        $this->app->singleton(IArticleService::class, ArticleService::class);
        $this->app->singleton(IUserPreferenceService::class, UserPreferenceService::class);
    }//end bootServiceDependencies
}//end class
