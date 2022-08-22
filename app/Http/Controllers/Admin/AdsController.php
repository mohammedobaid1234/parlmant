<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function index()
    {
        $ads = Ads::paginate(3);
        return view('admin.ads.index', [
            'ads' => $ads,
            'title' => 'كل الاعلانات',

        ]);
    }
    public function create()
    {
        return view('admin.ads.create', [
            'title' => 'اضافة اعلان جديد'
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'type' => 'required|in:1,2,3'
        ]);
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $image_url = $uploadedFile->store('/', 'upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }
        $add = Ads::create($request->all());

        return redirect()->route('ads.index')->with(['success' => 'تم اضافة الاعلان بنجاح']);
    }

    public function edit($id)
    {
        $ad = Ads::findOrFail($id);
        return view('admin.ads.edit', [
            'title' => 'تعديل الاعلان',
            'ad' => $ad
        ]);
    }

    public function update(Request $request, $id)
    {
        $ad = Ads::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image',
            'type' => 'required|in:1,2,3'
        ]);
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $image_url = $uploadedFile->store('/', 'upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }
        $ad->update($request->all());
        return redirect()->route('ads.index')->with(['success' => 'تم تعديل الاعلان بنجاح']);
    }

    public function destroy($id)
    {
        $ad = Ads::findOrFail($id);
        $ad->delete();
        return redirect()->route('ads.index')->with(['success' => 'تم حذف الاعلان بنجاح']);
    }
}