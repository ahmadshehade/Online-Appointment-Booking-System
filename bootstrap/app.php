<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Add global middleware here if needed
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {

            // Validation errors
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'message' => 'The provided data is invalid.',
                    'errors' => $e->errors(),
                ], 422);
            }

            // Authentication errors
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json([
                    'message' => 'Authentication is required.',
                ], 401);
            }

            // Authorization errors (policies/gates or 403 HttpException)
            if ($e instanceof \Illuminate\Auth\Access\AuthorizationException ||
                ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException && $e->getStatusCode() === 403)) {
                return response()->json([
                    'message' => 'You are not authorized to perform this action.',
                ], 403);
            }

            // Not found
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ||
                $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return response()->json([
                    'message' => 'The requested resource was not found.',
                ], 404);
            }

            // Database errors
            if ($e instanceof \Illuminate\Database\QueryException) {
                return response()->json([
                    'message' => 'A database error occurred.',
                ], 500);
            }

            // Fallback for unexpected errors
            return response()->json([
                'message' => 'An unexpected error occurred.',
            ], 500);
        });
    })
    ->create();
