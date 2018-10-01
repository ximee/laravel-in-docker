<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AvatarGenerator\AvatarGenerator;
use App\Support\Contracts\AvatarGeneratorContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerAvatarGenerator();
    }

    /**
     * Register avatar generator instance.
     *
     * @return void
     */
    protected function registerAvatarGenerator(): void
    {
        $this->app->bind(AvatarGeneratorContract::class, AvatarGenerator::class);

        $this->app->bind('avatar_generator', AvatarGeneratorContract::class);
        $this->app->bind('avatar.generator', AvatarGeneratorContract::class);
    }
}
