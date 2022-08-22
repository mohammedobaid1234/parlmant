<x-main-layout title="{{$title}}" >
    <x-form-new-button label='اضافة عضو جديد' action='users.newCreate' />

    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <div class="container-fluid" >
        <table class="table table-striped" style="width:90%; margin-bottom:0">
            <thead style="color: #21457d">
                <tr >
                    <th scope="col">الاسم</th>
                    <th scope="col">رقم الجوال</th>
                    <th scope="col">حول</th>
                    <th scope="col">الصورة</th>
                  
                    <th scope="col">الدائرة</th>
                    <th scope="col" >
                        تاريخ الانشاء
                    </th>
                    <th scope="col" style="text-align: center">
                        
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->name }}</th>
                    <td>{{ $user->phone_number }}</td>
                    <td class="report">{{ $user->about }}</td>
                    <td><img width="60" style="border-radius: 6px"  src="{{ $user->image_path }}" alt=""></td>
            
                    @if ($user->type == 2)    
                    <td id='type' style="width: 25%">
                        @if ($user->council->parent == null)
                           {{ $user->council->name }}
                        @else
                        {{ $user->council->parent->name }} 
                        [{{$user->council->name}}]
                        @endif
                    </td>
                    @else
                    <td>{{$user->user_type}}</td>
                    @endif
                    <td class="report">{{$user->created_at}}</td>
                       <td>
                        <a class="btn btn-sm btn-primary" href='{{route('users.edit', [$user->id])}}'>
                         <div style="width: 60px" class="d-flex justify-content-between align-items-center">                        
                        <i class="far fa-edit" style="margin-right:5px"></i> <span>تعديل</span>
                        </div>
                        </a>
                    </td>
                    <form class="delet-element" action="{{route('users.destroy',[$user->id])}}" method="POST">
                        @method('delete')
                        @csrf
                        <td>
                            <button type="submit" class="btn btn-sm btn-danger">
                             <div style="width: 55px" class="d-flex justify-content-between align-items-center">                        
                             <i class="far fa-trash-alt" style="margin-right:5px"></i> <span>حذف</span>
                             </div>
                             </button>

                        </td>
                    </form>
                </tr>
                @endforeach

            </tbody>
        </table>
        @if($users instanceof \Illuminate\Pagination\AbstractPaginator)

        {{$users->withQueryString()->links()}}
     

        @endif

    </div>
</x-main-layout>