<x-main-layout :title="$title">
  @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <form enctype="multipart/form-data" action="{{route('newspapers.update', [$newspaper->id])}}" method="POST" style="width:80%" >
        @csrf
      @method('put')
    <img src="{{old('image', $newspaper->image_path ?? null)}}" style="width: 100px; height: 100px">
      <x-form-image type="file" name="image" label="" value="{{$newspaper->image_path}}"  />
        <x-form-textarea name="title" label="عنوان الفيديو" value="{{$newspaper->title}}"/>
      <x-form-input name="newspaper_url" label="رابط المقال" value="{{$newspaper->newspaper_url}}"/>
      <button style="padding: 10px" class="btn btn-primary">تعديل</button>
    </form>
</x-main-layout>