<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\LoanDetailRepositoryInterface;
use App\Repositories\LoanDetailRepository;
use App\Services\Contracts\EMIServiceInterface;
use App\Services\EMIService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LoanDetailRepositoryInterface::class, LoanDetailRepository::class);

        $this->app->bind(EMIServiceInterface::class, EMIService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
