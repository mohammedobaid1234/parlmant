{{-- <x-main-layout :title="$title">
    <div class="container-fluid">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-form-input name='name' label='اسم العضو' :value={{$user->naem}} />
            <x-form-input name='phone_number' label='رقم الجوال' :value={{$user->phone_number}}/>
            @if ($children->count() > 0)  
            <div class="form-group">
                <label for="name">اختر {{$type}}</label>
                <select id="select1" name="council_id" class="form-control">
                    @foreach($children as $key => $value)
                    <option class="form-group" value={{$key}}>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div style="padding-top: 10px" class="form-group">
                <x-form-input type='hidden' name='type' label='' value='عضو مجلس' />

                <button type="submit" class="btn btn-primary">تسجيل عضو</button>
            </div>
        </form>
    </div>

</x-main-layout> --}}
<x-main-layout title="{{ $title }}">
  @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <div class="container-fluid" >

        <form style="padding-top:10px; width:60%;" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
              <img class="mb-4" src="{{old('image', $user->image_path)}}" style="width: 150px; border-radius:6px">
            <x-form-input name='name' label='اسم العضو' :value="$user->name"/>
            <x-form-input name='phone_number' label='رقم الجوال' :value="$user->phone_number"/>
            <label for="" style="padding-right: 10px; margin:10px 0 0">أختر نوع العضو</label>
              <div class="form-check" style="margin: 10px">
                <input class="form-check-input" type="radio" name="type"  id="type1" value="عضو مجلس">
                <label class="form-check-label" for="type1">
                  عضو مجلس
                </label>
              </div>
              <div class="form-check" style="margin: 10px">
                <input class="form-check-input" type="radio" name="type" id="type2" value="عضو فعال" checked>
                <label class="form-check-label" for="type2">
                  عضو فعال
                </label>
              </div>
              <div class="form-check" style="margin: 10px">
                <input class="form-check-input" type="radio" name="type" value="أدمن" id="type3">
                <label class="form-check-label" for="type1">
                    أدمن
                </label>
              </div>
             
            
            <div class="form-group" id="council" style="display: none">
                <label for="name">اختر المجلس</label>
                <select id='select3' style="margin-bottom: 10px" name="council_id" class="form-control">
                    <option value="">اختر المجلس</option>
                    @foreach($councils as $key => $value)
                    <option class="form-group" value={{$key}}>{{$value}}</option>
                    @endforeach
    
                </select>
                <select style="display: none;" name="council_id" class="form-control" id="select-main1">
                </select>
                
            </div>
            <div class="form-group" id="password-admin" style="display: none">
                <x-form-input name='password' type='password' label='كلمة المرور' />
            </div>
            <button type="submit" class="btn " style="background: #1e2f48;color:#fff; margin: 10px">تعديل</button>
        </form>
    </div>
</x-main-layout>