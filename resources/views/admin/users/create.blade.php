<x-main-layout :title="$title">
    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <div class="container-fluid">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-form-input name='name' label='اسم العضو' />
            <x-form-input name='phone_number' label='رقم الجوال' />
            @if ($children->count() > 0)  
            <div class="form-group p-1">
                <label for="name">اختر القسم</label>
                <select id="select1" name="council_id" class="form-control">
                    @foreach($children as $key => $value)
                    <option class="form-group" value={{$key}}>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @else
                <input type="text" hidden name="council_id" value="{{$type}}">
            @endif
            <div style="padding-top: 10px" class="form-group">
                <x-form-input type='hidden' name='type' label='' value='2' />

                <button type="submit" class="btn" style="background: #1e2f48;color:#fff">تسجيل عضو</button>
            </div>
        </form>
    </div>

</x-main-layout>