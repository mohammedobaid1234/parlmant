<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class aboutAppContoller extends Controller
{
    public function index()
    {

        $about = "تطبيق يجمع البرلمانات الكويتية في تطبيق واحد حيث يعرض الأخبار ويعرض الصور ولكل عضو
        في هذا التطبيق ملفه الخاص حيث يمكنه كتابة التغريدات واستقبال التعليقات من 
        المستخدمين الأخرين ويمكنه التواصل مع بعضهم البعض عن طريق مراسلة ويمكن للمستخدمين تلقى الاشعارات.";

        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => ' التغريدات'
                ],
                'data' => $about
            ],
            200
        );
    }
}