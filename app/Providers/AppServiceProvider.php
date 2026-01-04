<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// -- tambahkan ini
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Observers\UserObserver;
use App\Observers\RoleObserver;
use App\Observers\PermissionObserver;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
    \Illuminate\Auth\Events\Login::class => [
        \App\Listeners\LogSuccessfulLogin::class,
    ],
    \Illuminate\Auth\Events\Logout::class => [
        \App\Listeners\LogLogout::class,
    ],
    \Illuminate\Auth\Events\Failed::class => [
        \App\Listeners\LogFailedLogin::class,
    ],
];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
    {
        // Observer untuk User
        User::observe(UserObserver::class);

        // Observer untuk Role
        Role::observe(RoleObserver::class);

        // Observer untuk Permission
        Permission::observe(PermissionObserver::class);

        $helper = app_path('Helpers/SettingsHelper.php');
            if (file_exists($helper)) {
                require_once $helper;
            }
            
 // SHARE GLOBAL SETTINGS KE VIEW
    view()->share([
        // Nama aplikasi (fallback ke config jika kosong)
        'app_name'      => get_setting('app_name', config('app.name')),
        // Tagline
        'app_tagline'   => get_setting('app_tagline', ''),
        // Tagline1
        'app_tagline1'   => get_setting('app_tagline1', ''),
        // Tagline2
        'app_tagline2'   => get_setting('app_tagline2', ''),
        // Footer
        'footer_text'   => get_setting('footer_text', ''),
        // Logo (jadikan path lengkap ke asset)
        'app_logo'      => get_setting('app_logo') ? asset('storage/' . get_setting('app_logo')) : null,
        // Favicon
        'app_favicon'   => get_setting('app_favicon') ? asset('storage/' . get_setting('app_favicon')) : null,
    ]);
    }
}