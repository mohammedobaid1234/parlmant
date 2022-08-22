<x-main-layout title="{{ $title }}">
    {{-- {{dd($councils)}} --}}
    <form action="{{ route('users.newStore') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-form-input name='name' label='اسم القسم' />        
        <div class="form-group"  style="padding: 10px">
            <label for="name">اختر المجلس</label>
            <select  style="margin-bottom: 10px" name="parent_id" class="form-control">
                <option value="">اختر المجلس</option>
                @foreach($councils as $key => $value)
                <option class="form-group" value={{$key}}>{{$value}}</option>
                @endforeach

            </select>
       
            
        </div>
        
        <button type="submit" class="btn btn-primary" style="margin: 10px">اضافة</button>
    </form>
</x-main-layout>