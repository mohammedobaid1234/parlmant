<x-main-layout :title="$title">
  @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <form enctype="multipart/form-data" action="{{route('newspapers.store')}}" method="POST" style="width:80%" >
        @csrf
      <x-form-image type="file" name="image" label="صورة" />
      <x-form-textarea name="title" label="عنوان الجريدة الالكترونية"/>
      <x-form-input name="newspaper_url" label="رابط الجريدة الالكترونية" />
      <button style="padding: 10px" class="btn btn-primary">اضافة </button>
    </form>
</x-main-layout>