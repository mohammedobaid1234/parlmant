<x-main-layout :title="$title" >
    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <x-form-new-button label='اضافة مقال جديد' action='articles.create' />
    @if ($articles->count() == 0)
                <div class="alert alert-danger">عذرا لا يوجد مقالات</div>
    @else
        <table class="table table-striped" style="width:90%">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">صورة</th>
                <th scope="col"  >العنوان</th>
                <th scope="col"  >الرابط</th>
                <th>تاريخ الاضافة</th>
                <th scope="col"></th>
                <th scope="col"></th>
                
            </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)       
                    <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <th scope="row">
                        <img width="100px" src="{{$article->image_path}}" alt="..." />
                    </th>
                    <th scope="row" >{{$article->title}}</th>
                    <th scope="row" class="report"
                    ><a href= "https://{{ $article->article_url}}">{{$article->article_url}}</a></th>
                    <th scope="row" >{{$article->created_at}}</th>
                    
                    <td>
                        <a class="btn btn-sm btn-primary" href='{{route('articles.edit', [$article->id])}}'>
                            <div style="width: 60px" class="d-flex justify-content-between align-items-center">                        
                               <i class="far fa-edit" ></i> <span>تعديل</span>
                            </div>
                        </a>
                    </td>
                    <form class="delet-element" action="{{route('articles.destroy',[$article->id])}}" method="POST">
                        @method('delete')
                        @csrf
                        <td>
                            <button type="submit" class="btn btn-sm btn-danger">
                                <div style="width: 55px" class="d-flex justify-content-between align-items-center">                        
                                   <i class="far fa-trash-alt" ></i> <Span>حذف</span>
                                </div>
                             </button>
                        </td>
                    </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$articles->withQueryString()->links()}}

    @endif
</x-main-layout>