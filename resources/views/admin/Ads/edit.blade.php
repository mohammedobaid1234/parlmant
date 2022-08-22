<x-main-layout :title="$title">
    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <form enctype="multipart/form-data" action="{{route('ads.update', $ad->id)}}" method="POST" style="width:80%">
        @csrf
        @method('put')
        <img src="{{old('image', $ad->image_path ?? null)}}" style="width: 100px; height: 100px">
        <x-form-input type="file" name="image" label="" />
        <div class="form-group p-1">
            <label for="type">اختر النوع</label>
            <select id="select1" name="type" class="form-control">
                @foreach([1, 2, 3] as $key => $value)
                <option class="form-group" @if($value==$ad->type) @endif value={{$value}}>
                    @php
                    if($value == 1) {
                    echo 'رخيص';
                    } elseif ($value == 2) {
                    echo 'متوسط';
                    } else{
                    echo 'غالي';
                    }
                    @endphp
                </option>
                @endforeach
            </select>
        </div>
        <button style="padding: 10px" class="btn btn-primary">تعديل</button>
    </form>
</x-main-layout>