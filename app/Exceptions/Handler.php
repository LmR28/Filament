<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [
        // 'reportable' => \Psr\Log\LogLevel::ALERT,
    ];

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if (
            $exception instanceof \Illuminate\Database\QueryException
            && str_contains($exception->getMessage(), 'UNIQUE constraint failed')
        ) {
            return back()
                ->withErrors(['email' => 'Este correo ya está registrado.'])
                ->withInput();
        }

        return parent::render($request, $exception);
    }
}