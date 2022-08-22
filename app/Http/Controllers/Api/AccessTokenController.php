<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AccessTokenController extends Controller
{
    public function checkUser(Request $request)
    {
        $request->validate([
            'phone_number' => 'required'
        ]);
        
        $phone = trim($request->phone_number);
        $user = User::where('phone_number', $phone)->first();
        if (!$user) {
            return  response()->json(
                [
                    'status' => [
                        'code' => 404,
                        'status' => false,
                        'message' => 'هذا العنصر غير موجود'
                    ],
                    'data' => null
                ],
                404
            );
        }
        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => 'هذا العنصر موجود'
                ],
                'data' => $user
            ],
            200
        );
        // return $user;
    }

    public function receiveCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'phone_number' => 'required'
        ]);
        $phone = trim($request->phone_number);

        $user = User::where('phone_number', $phone)->first();
        $user->update([
            'code' => $request->code
        ]);
        return  response()->json(
            [
                'status' => [
                    'code' => 201,
                    'status' => true,
                    'message' => 'تم ارسال رمز التحقق '
                ],
                'data' => $user
            ],
            201
        );
    }

    public function checkCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'phone_number' => 'required'
        ]);
        $phone = trim($request->phone_number);

        $user = User::where('phone_number', $phone)->first();
        if($user->code === $request->code){

            return  response()->json(
                [
                    'status' => [
                        'code' => 200,
                        'status' => true,
                        'message' => 'تم التحقق من رمز التحقق '
                    ],
                    'data' => $user
                ],
                200
            );
        }
        return  response()->json(
            [
                'status' => [
                    'code' => 401,
                    'status' => true,
                    'message' => 'رمز التحقق غير صحيح '
                ],
                'data' => $user
            ],
            401
        );

    }
    
    public function store(Request $request)
    {
        $request->validate([
            'phone_number' => ['required'],
            'device_name' => ['required'],
            // 'code' => ['required']
        ]);
        $phone = trim($request->phone_number);

        $user = User::where('phone_number', $phone)
            ->first();

        // $this->ensureIsNotRateLimited($request);
        if (!$user) {
            // RateLimiter::hit($this->throttleKey());
            return  response()->json(
                [
                    'status' => [
                        'code' => 404,
                        'status' => false,
                        'message' => 'العضو غير موجود'
                    ],
                    'data' => null
                ],
                404
            );
        }
        $token = $user->createToken($request->device_name);
        $user->update([
            'code' => null
        ]);
        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => "تم تسجيل الدخول"
            ],
            'data' => [
                'token' => $token->plainTextToken,
                'user' =>  $user,
            ]
        ], 200);
    }
    public function destroy()
    {
        $user = Auth::guard('sanctum')->user();
        
        // Revoke (delete) all user tokens
        //$user->tokens()->delete();

        // Revoke current access token
        $user->currentAccessToken()->delete();
        return response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => 'تم تسجيل الخروج'
            ],
            'data' => null
        ], 200);
    }
    // /**
    //  * Ensure the login request is not rate limited.
    //  *
    //  * @return void
    //  *
    //  * @throws \Illuminate\Validation\ValidationException
    //  */
    // public function ensureIsNotRateLimited(Request $request)
    // {
    //     if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
    //         return;
    //     }

    //     event(new Lockout($this));

    //     $seconds = RateLimiter::availableIn($this->throttleKey());

    //     throw ValidationException::withMessages([
    //         'phone_number' => trans('auth.throttle', [
    //             'seconds' => $seconds,
    //             'minutes' => ceil($seconds / 60),
    //         ]),
    //     ]);
    // }
    // /**
    //  * Get the rate limiting throttle key for the request.
    //  *
    //  * @return string
    //  */
    // public function throttleKey()
    // {
    //     return Str::lower($this->input('phone_number')).'|'.$this->ip();
    // }

}