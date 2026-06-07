<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (file_exists(app_path('Helpers/TranslationHelper.php'))) {
            require_once app_path('Helpers/TranslationHelper.php');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Only register view composers after migration is complete
        if ($this->app->runningInConsole() && app()->runningUnitTests() === false) {
            return;
        }

        try {
            if (Schema::hasTable('reviews')) {
                View::composer('layouts.admin', function ($view) {
                    $pendingReviews = \App\Models\Review::where('status', 'pending')->count();
                    $unreadMessages = \App\Models\Message::where('status', 'unread')->count();
                    
                    $view->with([
                        'notif_count' => $pendingReviews + $unreadMessages,
                        'pending_reviews_count' => $pendingReviews,
                        'unread_messages_count' => $unreadMessages
                    ]);
                });
            }

            if (Schema::hasTable('company_settings')) {
                View::composer('*', function ($view) {
                    $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first()) ?? new \App\Models\CompanyConfig();
                    $view->with('settings', $settings);
                });
            }
        } catch (\Exception $e) {
            // Silently skip if database not ready
        }
    }
}
