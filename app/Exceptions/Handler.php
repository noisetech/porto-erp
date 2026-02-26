<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {

            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $e->errors()
                ], 422);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada server',
            ], 500);
        }

        return parent::render($request, $e);
    }
}
