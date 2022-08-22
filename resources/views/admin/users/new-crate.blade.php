<x-main-layout title="{{ $title }}">
    <form action="{{ route('users.newStore') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-form-input name='name' label='اسم العضو' />
        <x-form-input name='phone_number' label='رقم الجوال' />
        <label for="" style="padding-right: 10px">أختر نوع العضو</label>
          <div class="form-check" style="margin: 10px">
            <input class="form-check-input" type="radio" name="type"  id="type1" value="2">
            <label class="form-check-label" for="type1">
              عضو مجلس
            </label>
          </div>
          <div class="form-check" style="margin: 10px">
            <input class="form-check-input" type="radio" name="type" id="type2" value="1" checked>
            <label class="form-check-label" for="type2">
              عضو فعال
            </label>
          </div>
          <div class="form-check" style="margin: 10px">
            <input class="form-check-input" type="radio" name="type" value="3" id="type3">
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
        <button type="submit" class="btn" style="background: #1e2f48;color:#fff; margin: 10px">اضافة</button>
    </form>
</x-main-layout>