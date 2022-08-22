<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Ads;
use App\Models\Council;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class CouncilsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => 'المجالس الرئيسية'
            ],
            'data' => Council::whereNull('parent_id')->get(['name','id'])
        ],
         200); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }
    public function main()
    {
        
        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => 'الصفحة الرئيسية'
            ],
            'data' => [
                'main' => Report::get(),
                'ads' => Ads::get(),
            ]
        ],
         200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parent_council = Council::with('users','children')->find($id);
        if(!$parent_council){

            return  response()->json([
                'status' => [
                    'code' => 404,
                    'status' => true,
                    'message' => 'هذا المجلس غير موجود'
                ],
                'data' => null
            ],
             404);
        }
        if($parent_council->children->count() > 0 ){
          
           $councils = $parent_council->load('children:id,name,parent_id');
           return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => 'المجالس الفرعية'
            ],
            'data' => $parent_council->children
        ],
         200);
        }
        
        $council = $parent_council->load('children.users');
        $users = collect([]);
        $users1 = $council->users;
        foreach($users1 as $child){
            $id = $child->id;
            $name = $child->name;
            $image_path = $child->image_path;
            $array = [
                'id' => $id,
                'name' => $name,
                'image_url' => $image_path
            ];
           
            $users->push($array);  
        }
        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => 'أعضاء المجلس'
            ],
            'data' => $users
        ],
         200);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
