<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Council;
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
        $councils = Council::whereNull('parent_id')->orderBy('created_at','asc')->paginate(10);
        return view('admin.councils.index', [
            'councils' => $councils
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() // for create councils
    {
        // $councils = Council::whereNull('parent_id')
        //     ->pluck('name', 'id');
        return view('admin.councils.create-council');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5|unique:councils,name'
        ]);
        $council =  Council::create($request->all());
        if ($request->post('parent_id')) {
            $messege =  'تم اضافة دائرة جديد';
        } else {
            $messege =  'تم اضافة مجلس جديد';
        }
        return redirect(route('councils.index'))->with('success', $messege);
    }
    
    public function checkChildren($id)
    {
        $council = Council::with('children')->findOrFail($id);
       
        if($council->children->count() == 0){
            $users = $council->load('users');
            // $users = $users[0]->users;
            // return $users;
            
            // return $users->users;
            return view('admin.users.index', [
                'users' => $users->users,
                'title' => "  كل أعضاء  $council->name "
            ]);

        }else{
            $sections = $council->load('children');
            // return $sections->children;
            return view('admin.councils.show',[
                'sections' => $sections->children,
                'title' => "عرض جميع الاقسام",
                'type' => $council->type,
                'link' => $council->id
            ]);
            // return $council;

        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $council = Council::findOrFail($id);
        return view('admin.councils.edit', [
            'council' => $council
        ]);
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
        $request->validate([
            'name' => 'required|unique:councils,name,'.$id
        ]);
        $council = Council::findOrFail($id);
        $council->update($request->all());
        return redirect()->route('councils.index')->with(['success' => 'تم تعديل المجلس بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $council = Council::findOrFail($id);
        $council->delete();
        return redirect()->back()->with(['success' => 'تم حذف المجلس بنجاح']);
    }
}