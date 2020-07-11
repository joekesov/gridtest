<?php


namespace App\Application\Providers\Infrastructure;

use Illuminate\Support\ServiceProvider;

use App\Domain\Button\ButtonRepositoryInterface;
use App\Infrastructure\Button\ButtonRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind(ButtonRepositoryInterface::class, ButtonRepository::class);
    }
}
