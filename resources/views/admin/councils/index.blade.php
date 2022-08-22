<x-main-layout title="كل المجالس">
    <div class="top-button" style="display:flex">

        <x-form-new-button label='اضافة قسم تابع لمجلس' action='sections.before' />
        <x-form-new-button label='اضافة مجلس رئيسي' action='councils.create' />
    </div>
    

    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <div class="container-fluid">
        <table class="table table-striped" style="width: 94%; margin-bottom:0">
            <thead>
                <tr>
                    <th>#</th>
                    <th scope="col">اسم المجلس</th>
                    
                    <th scope="col">
                        تاريخ الانشاء
                    </th>
                    <th scope="col" style="text-align: center; ">
                       <div style="width: 57%"> </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($councils as $council)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>

                    <th scope="row"><a href="{{route('council.checkChildren', $council->id)}}">{{ $council->name }}</a></th>
                    {{-- @if ($council->id == 5)
                        <td><x-form-new-button label='اضافة نادي' action="users.newCreate"  /></td>
                        @elseif($council->id == 3 )   
                        <td><x-form-new-button label='اضافة  عضو' action="users.newCreate"  /></td>
                        
                        @else
                        <td><x-form-new-button label='اضافة  {{$council->type}}' action="sections.create" :id="$council->id" /></td>
                            @endif --}}
                    <td>{{$council->created_at}}</td>
                    
                    <td >
                            <div class="d-flex align-items-center justify-content-between" style="width: 57%">

                                <a href="{{route('users.create', $council->id)}}" class="btn btn-sm" style="background: #1e2f48;color:#fff;justify-contnet:center">اضافة عضو</a>
                                <a class="btn btn-sm btn-success" href="{{ route('councils.edit', $council->id) }}">تعديل</a>
                                <form style="display: inline" class="delet-element" action="{{ route('councils.destroy', $council->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    
                                    <button type="submit" class="btn btn-sm btn-danger"> حذف </button>
                                </form>
                            </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{$councils->withQueryString()->links()}}
    </div>
</x-main-layout>