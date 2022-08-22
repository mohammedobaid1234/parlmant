<x-main-layout :title="$title">
  @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    @if(Session::has('success'))
      <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <form enctype="multipart/form-data" action="{{route('reports.update', [$report->id])}}" method="POST" style="width:80%" >
        @csrf
      @method('put')
    <img src="{{old('image', $report->image_path ?? null)}}" style="width: 100px; height: 100px">
      <x-form-image type="file" name="image" label="" value="{{$report->image_path}}"  />
      <x-form-input name="title" label="عنوان الخبر" value="{{$report->title}}"/>
      <x-form-textarea name="body" label="محتوى الخبر" value="{{$report->body}}"/>
      <button style="padding: 10px" class="btn btn-primary">تعديل</button>
    </form>
</x-main-layout>