<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Event;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;
// use App\Http\Requests\LoginRequest;
// use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect('/login');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

        //追加
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                // 登録直後にプロフィール設定画面にリダイレクト
                return redirect()->route('verification.notice');
            }
        });
    }
}
