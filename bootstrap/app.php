<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cms.auth' => \App\Http\Middleware\EnsureStaffHasCmsAccess::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('admin/*') || $request->is('staff/*')) {
                return route('staff.login');
            }
            if ($request->is('student/*')) {
                return route('student.login');
            }
            return route('staff.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            if ($request->is('admin/*') || $request->is('staff/*')) {
                return redirect()->route('staff.login')->with('error', 'Your session has expired. Please log in again.');
            }
            if ($request->is('student/*')) {
                return redirect()->route('student.login')->with('error', 'Your session has expired. Please log in again.');
            }
            
            return redirect()->route('staff.login')->with('error', 'Your session has expired. Please log in again.');
        });
    })->create();
