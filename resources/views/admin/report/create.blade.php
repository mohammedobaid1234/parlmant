<x-main-layout :title="$title">
  @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <form enctype="multipart/form-data" action="{{route('reports.store')}}" method="POST" style="width:80%" >
        @csrf
      <x-form-input type="file" name="image" label=""   />
      <x-form-input name="title" label="عنوان الخبر" />
      <x-form-textarea name="body" label="محتوى الخبر"/>
      <button style="padding: 10px" class="btn btn-primary">اضافة </button>
    </form>
</x-main-layout>