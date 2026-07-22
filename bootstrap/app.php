<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 404 différenciée : back-office si admin connecté, sinon publique
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('admin*') && auth()->check()) {
                return response()->view('admin.errors.404', [], 404);
            }

            return response()->view('front.errors.404', [], 404);
        });
    })->create();
