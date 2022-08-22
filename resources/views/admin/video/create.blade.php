<x-main-layout :title="$title">
  @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <form enctype="multipart/form-data" action="{{route('videos.store')}}" method="POST" style="width:80%" >
        @csrf
      <x-form-image type="file" name="image" label="صورة" />
      <x-form-input name="title" label="عنوان الفيديو"/>
      <x-form-input name="video_url" label="رابط الفيديو" />
      <button style="padding: 10px" class="btn btn-primary">اضافة </button>
    </form>
</x-main-layout>