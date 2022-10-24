<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
        //
    }
    
    public function boot(): void
    {
        Model::shouldBeStrict(!app()->isProduction());

        if (app()->isProduction()) {

            // Соединение (от открытия до закрытия)
            /*DB::whenQueryingForLongerThan(CarbonInterval::seconds(5), function (Connection $connection) {
                logger()->channel('telegram')->debug('totalQueryDuration: ' . $connection->totalQueryDuration());
            });*/

            // Каждый запрос
            DB::listen(function ($query) {
                if ($query->time > 100) {
                    logger()->channel('telegram')->debug('Query longer than 1ms (sql, bindings): ' . $query->sql, $query->bindings);
                }
            });

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function () {
                    logger()->channel('telegram')->debug('whenRequestLifecycleIsLongerThan: ' . request()->url());
                }
            );

        }
    }
}
