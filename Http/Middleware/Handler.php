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
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                \DGII\Http\Middleware\Web\Login::class,
            ]
        ];
    }

    public function routes()
    {
        return [
        ];
    }
}