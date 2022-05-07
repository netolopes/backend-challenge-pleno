<?php

namespace App\Providers;

use App\Repositories\Categoria\CategoriaRepository;
use App\Repositories\Contracts\ICategoriaRepository;
use App\Repositories\Contracts\IProdutoRepository;
use App\Repositories\Produto\ProdutoRepository;
use App\Services\Categoria\CategoriaService;
use App\Services\Contracts\ICategoriaService;
use App\Services\Contracts\IProdutoService;
use App\Services\Produto\ProdutoService;
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
       $this->app->bind(IProdutoService::class,  ProdutoService::class,);

       //repositories
       $this->app->bind(ICategoriaRepository::class, CategoriaRepository::class);
       $this->app->bind(IProdutoRepository::class, ProdutoRepository::class);
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
