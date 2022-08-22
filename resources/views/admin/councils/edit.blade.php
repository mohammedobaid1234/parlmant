<x-main-layout title="اضافة مجلس">
    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <div class="container-fluid">
        <form action="{{ route('councils.update', $council->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
                <x-form-input name="name" label="اسم المجلس" value="{{$council->name}}" />
                <button type="submit" class="btn btn-primary">تعديل</button>
            </form>
        </div>
    
</x-main-layout>