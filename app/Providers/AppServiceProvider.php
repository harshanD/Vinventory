<?php

namespace App\Providers;

use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;

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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $report = new ReportsController;
        $notifications = $report->notifications();
        $agent = new Agent();
        View::share(['notifications' => $notifications, 'desktop' => $agent->isDesktop(), 'table_responsive' => ($agent->isDesktop()) ? '' : 'table-responsive']);
    }
}
