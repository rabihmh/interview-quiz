<?php

namespace App\Providers;

use App\Actions\Fortify\AuthenticateUser;
use App\Actions\Fortify\AuthenticateUsing;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetAdminPassword;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request = request();
        if ($request->is('admin/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.prefix', 'admin/dashboard');
            Config::set('fortify.home', '/');
        }
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request): RedirectResponse
            {
                if ($request->user('admin')) {
                    return redirect()->intended('admin/dashboard');
                }
                return redirect()->intended('/');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        if (Config::get('fortify.guard') == 'admin') {
            Fortify::viewPrefix('admin.auth.');
            Fortify::authenticateUsing([new AuthenticateUsing(), 'authenticate']);
            Fortify::resetUserPasswordsUsing(ResetAdminPassword::class);

        } else {
            Fortify::viewPrefix('front.auth.');
            Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        }
    }
}
