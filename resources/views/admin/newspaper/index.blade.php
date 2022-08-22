<x-main-layout :title="$title" >
    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <x-form-new-button label='اضافة جريدة الكترونية جديد' action='newspapers.create' />
    @if ($newspapers->count() == 0)
                <div class="alert alert-danger">عذرا لا يوجد جردائد</div>
    @else
        <table class="table table-striped" style="width:90%">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">الصورة</th>
                <th scope="col">العنوان</th>
                <th scope="col">الرابط</th>
                <th scope="col">تاريخ الانشاء</th>
                <th scope="col"></th>
                
            </tr>
            </thead>
            <tbody>
                @foreach ($newspapers as $newspaper)       
                    <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td scope="row">
                        <img width="100px" src="{{$newspaper->image_path}}" alt="..." />
                    </td>
                    <td scope="row">{{$newspaper->title}}</td>
                    <td scope="row" class="report"><a href="https://{{$newspaper->newspaper_url}}">{{$newspaper->newspaper_url}}</a></td>
                    <td scope="row">{{$newspaper->created_at}}</td>
                    
                    <td>
                        <a class="btn btn-sm btn-primary" href='{{route('newspapers.edit', [$newspaper->id])}}'>
                           <div style="width: 60px" class="d-flex justify-content-between align-items-center">                        
                                <i class="far fa-edit" style="margin-right:5px"></i>
                                <span> تعديل </span>
                            </div>
                        </a>
                    </td>
                    <form class="delet-element" action="{{route('newspapers.destroy',[$newspaper->id])}}" method="POST">
                        @method('delete')
                        @csrf
                        <td>
                            <button type="submit" class="btn btn-sm btn-dark"> 
                                <div style="width: 55px" class="d-flex justify-content-between align-items-center">                        
                                    <i class="far fa-trash-alt" style="margin-right:5px"></i>
                                    <span>حذف</span>
                                </div>
                            </button>
                        </td>
                    </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$newspapers->withQueryString()->links()}}

    @endif
</x-main-layout>