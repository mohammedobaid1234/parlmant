<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdsController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'image_url' => 'required|image',
            'type' => 'required|in:1,2,3'
        ]);
        $add = Ads::create($request->all());

        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => ''
                ],
                'data' => Ads::paginate(3)
            ],
            200
        );
    }
}