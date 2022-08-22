<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Council;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('council')->orderBy('created_at','asc')->paginate(10);
        // return $users;
        return view('admin.users.index', [
            'users' => $users,
            'title' => 'كل الاعضاء'
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $council = Council::findOrFail($id);
        
        $children = $council->load('children');
        
        // return $children->children;
        return view('admin.users.create',[
            'children' =>$children->children->pluck('name','id'),
            'title' => "اضافة عضو في " .$council->name,
            'type' => $id 
        ]);
        // $council = Council::findOrFail($id);
        // $children = $council->load('children');
        // $children = $children->children->pluck('name', 'id');
        // $name = $council->name;
        // return view('admin.users.create', [
        //     'children' => $children,
        //     'name' => $council->name,
        //     'type' => $council->type,
        //     'title' => "اضافة عضو في $name"
        // ]);
        
    }
    public function children($id)
    {
        $council = Council::findOrFail($id);
        
        $children = $council->load('children');
        
        return $children->children;
        
    }

    // to define what council that user want to add
    public function beforeCreate()
    {
        $councils = Council::whereNull('parent_id')->pluck('name','id');
        return view('admin.users.before-create',[
            'councils' => $councils,
            'title' =>'dd'
            
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

        $request->validate([
            'name' => 'required|unique:users,name',
            'phone_number' => 'required|unique:users,phone_number',
            'council_id' => 'required'
            
        ]);
        
        $user = User::create(
            $request->all()
        );
        return redirect()->back()->with(['success' => 'تم اضافة العضو بنجاح']);
    }
    public function newStore(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|unique:users,name',
            'phone_number' => 'required|unique:users,phone_number',
            'type' => ['required',Rule::in([1,2,3])],
        ]);
       if($request->type == 3){
           $request->validate([
            'password' => 'required',
           ]);
        $password = Hash::make($request->password);
        User::create([
            'name' => $request->name,
            'password' => $password,
            'phone_number' => $request->phone_number,
            'type' => $request->type
        ]);
        return redirect(route('users.index'))->with(['success' => 'تم اضافة العضو بنجاح']);

       }

        $user = User::create(
            $request->all()
        );
        return redirect(route('users.index'))->with(['success' => 'تم اضافة العضو بنجاح']);;
    }
    // for create all users type
    public function newCreate()
    {   
        $councils = Council::with('children')->whereNull('parent_id')->pluck('name', 'id');
       
        return view('admin.users.new-crate', [
            'councils' => $councils,
            'title' => "اضافة عضو"
         ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $councils = Council::whereNull('parent_id')->pluck('name','id');
        $user = User::findOrFail($id);
        return view('admin.users.edit', [
            'user' => $user,
            'title' => 'تعديل بيانات العضو',
            'councils' => $councils
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
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:users,name,'. $id,
            'phone_number' => 'required|unique:users,phone_number,'. $id,
            'type' => ['required',Rule::in([1,2,3])],
        ]);
       if($request->type == 3){
           $request->validate([
            'password' => 'required',
           ]);
       }
        $password = Hash::make($request->password);
        $request->merge([
            'password' => $password
        ]);
        $user->update($request->all());
        return redirect(route('users.index'))->with(['success' => 'تم تعديل بيانات العضو بنجاح'])->with(['success' => 'تم اضافة العضو بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect(route('users.index'))->with('success', 'تم حذف العضو');
    }
}
