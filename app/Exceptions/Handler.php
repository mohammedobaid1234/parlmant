<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AuthenticationException  $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => [
                        'code' => 401,
                        'status' => false,
                        'message' => 'validation'
                    ],
                    'message' => 'يجب عليك تسجيل الدخول'
                ], 401);
            }
        });
        $this->renderable(function (NotFoundHttpException  $e,  $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => [
                        'code' => 401,
                        'status' => false,
                        'message' => 'validation'
                    ],
                    'message' => 'الرابط غير موجود '
                ], 401);
            }
        });
        $this->renderable(function (ValidationException   $e, Request $request) {
            // $e->errors();

            if ($request->expectsJson()) {
                return new JsonResponse([
                    'status' => [
                        'code' => 422,
                        'status' => false,
                        'message' => 'validation'
                    ],
                    'message' => $e->errors()
                ], 422);
            }
        });
    }
}