<x-main-layout title="{{ $title }}">
    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif  
    <div class="container-fluid">
        <form action="{{route('sections.store', $id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-form-input name="name" label="اسم القسم" />
            <button type="submit" class="btn btn-primary">اضافة</button>
        </form>
    </div>

</x-main-layout>