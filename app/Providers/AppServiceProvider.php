<?php

namespace App\Providers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        JsonResource::withoutWrapping();
        Paginator::useBootstrap();
        Model::preventLazyLoading(!app()->isProduction());
        Model::handleLazyLoadingViolationUsing(function (Model $model, $relation) {
            logger('Lazy loading violation for model '.$model::class.' with relation '.$relation);
        });
    }

    private function configureCommands(): void
    {
        // TODO
        //  DB::prohibitDestructiveCommands({
        //   $this->>app->isProduction(),
        //   });

    }

    private function configureModels(): void
    {
        Model::shouldBeStrict();

        Model::unguard();
    }

    private function configureRequests(): void{
        URL::forceScheme('https');
    }

    private function configureVite():void{
        // TODO
        // Vite::usePrefetchStrategie('aggressive');
    }
}
