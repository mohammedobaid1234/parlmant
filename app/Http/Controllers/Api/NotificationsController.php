<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Converter\Number\GenericNumberConverter;
use Ramsey\Uuid\Math\BrickMathCalculator;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function index()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user->unreadNotifications->count() == 0) {
            return  response()->json(
                [
                    'status' => [
                        'code' => 404,
                        'status' => true,
                        'message' => 'لايوجد اشعارات'
                    ],
                    'data' => 'لا يوجد بيانات'
                ],
                404
            );
        }
        foreach ($user->unreadNotifications as $not) {
            // $converter = new GenericNumberConverter(new BrickMathCalculator());
            // return $converter->fromHex($not);
            $data[] = [
                'id' => $not->id,
                'data' => $not->data
            ];
        }

        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => 'الاشعارات'
                ],
                'data' => $data
            ],
            200
        );
        // return $notUser;
    }

    public function delete($id)
    {
        $user = Auth::guard('sanctum')->user();
        $notifciation = $user->notifications()->findOrFail($id);

        $notifciation->markAsRead();
        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => 'تم حدف الاشعار'
                ],
                'data' => 'لا يوجد بيانات'
            ],
            200
        );
    }
}