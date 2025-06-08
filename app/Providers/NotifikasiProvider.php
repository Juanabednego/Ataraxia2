<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AdminNotification; 

class NotifikasiProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         View::composer('layouts.AdminNav', function ($view) {
            // Jika ingin berdasarkan user:
            // $userId = auth()->id();
            // $notifications = Notification::where('user_id', $userId)->latest()->take(5)->get();

            $notifications = AdminNotification::where('is_read', 0)->latest()->get();
            $view->with('notifications', $notifications);
        });
    }
}
