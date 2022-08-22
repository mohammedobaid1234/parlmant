<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::orderBy('created_at','desc')->paginate(10);
        return view('admin.report.index' ,[
            'reports' => $reports,
            'title' => 'قسم الأخبار'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.report.create', [
            'title' => "اضافة خبر جديد"
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
            'title' => ['required'],
            'body' => ['required'],
            'image' => ['required', 'image'],
        ]);
        if($request->hasFile('image')){
            $file = $request->file('image');
            $image_url = $file->store('/', [
                'disk' => 'upload',
            ]);
            $request->merge([
                'image_url' => $image_url
            ]);
        }
        // dd($request);
        Report::create($request->all());
        return redirect()->route('reports.index')->with(['success' => 'تم اضافة الخبر بنجاح']);
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
        $report = Report::findOrFail($id);
        return view('admin.report.edit',[
            'report' => $report,
            'title' => 'صفحة التعديل'
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
        $report = Report::findOrFail($id);
        $request->validate([
            'title' => ['required'],
            'body' => ['required'],
            'image' => ['nullable', 'image'],
        ]);

       
        if($request->hasFile('image')){
            $uploadedFile = $request->file('image');
            Storage::disk('upload')->delete($report->image_url);
            $image_url = $uploadedFile->store('/','upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }

        $report->update($request->all());
        return redirect()->route('reports.index')->with(['success' => 'تم تعديل الخبر بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        Storage::disk('upload')->delete($report->image_url);
        Report::where('id', '=', $id)->delete();
        return redirect()->route('reports.index')->with(['success' => 'تم حذف الخبر بنجاح']);
    }
}
