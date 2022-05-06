<?php

namespace App\Providers;

use App\Repositories\Categoria\CategoriaRepository;
use App\Repositories\Contracts\ICategoriaRepository;
use App\Services\Categoria\CategoriaService;
use App\Services\Contracts\ICategoriaService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       //services
       $this->app->bind(ICategoriaService::class,CategoriaService::class);

       //repositories
       $this->app->bind(ICategoriaRepository::class, CategoriaRepository::class);
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
