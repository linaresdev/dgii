<?php
namespace DGII\Http\Middleware;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class Handler
{
    public function init()
    {
        return [
        ];
    }

    public function groups()
    {
        return [
            "web" => [
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \App\Http\Middleware\VerifyCsrfToken::class,
                \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
                \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                \DGII\Http\Middleware\Web\Login::class,
                \DGII\Http\Middleware\Api\AuthMiddleware::class,
            ],
            "dgii" => [
                \DGII\Http\Middleware\Api\AuthMiddleware::class,
            ],
            "entity" => [
                \DGII\Http\Middleware\EntityMiddleware::class, 
            ]
        ];
    }

    public function routes()
    {
        return [
        ];
    }
}