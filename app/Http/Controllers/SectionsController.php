<?php

namespace App\Http\Controllers;

use App\Models\Council;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
    }
    public function newCreate()
    {
        $councils = Council::whereNull('parent_id')->pluck('name','id');
        // return $councils;
        return view('admin.sections.new-create', [
            'councils' => $councils,
            'title' => 'اضافة قسم تابع لمجلس'
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSection($id) // for create circles
    {   
        
        $council = Council::whereNull('parent_id')->findOrFail($id);
       
        // return $councils;
        // if($council->name == "المجلس الطلابي" || $council->name == "مجالس النوادي"){
        //     return redirect()->route('home.index');
        // }
        return view('admin.sections.create-section', [
          
            'title' => "اضافة قسم",
            'type' => $council->type,
            'id' => $id
           
        ]);
    }
    public function sectionStore(Request $request,$id)
    {
        $request->validate([
            'name' => ['required','unique:councils,name']
        ]);
        $request->merge(['parent_id' => $id]);
        Council::create($request->all());
        return redirect()->back()->with(['success' => 'تم اضافة القسم بنجاح']);
    }
    public function beforeCreate()
    {   
        $councils = Council::whereNull('parent_id')
        // ->where('hasChild','!==', '0')
        ->pluck('name','id');
        return view('admin.sections.before-create',[
            'councils' => $councils,
            
        ]);   
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

   public function update(Request $request, $id)
   {
       $section = Council::findOrFail($id);
       $section->update($request->all());
       return redirect()->back()->with(['success' => 'تم تعديل القسم بنجاح']);
   }

 
   public function destroy($id)
   {
       // dd('dd');
       $section = Council::where('id', $id)->first();
       $section->delete();
       return  redirect()->route('councils.index')->with(['success' => 'تم حذف القسم بنجاح']);
   }
  

  

}
