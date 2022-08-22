<x-main-layout :title="$title">
    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <x-form-new-button label='اضافة مقطع فيديو جديد' action='videos.create' />

    @if ($videos->count() == 0)
                <div class="alert alert-danger">عذرا لا يوجد مقاطع فيديو</div>
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
                @foreach ($videos as $video)       
                    <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td scope="row">
                        <img width="100px" src="{{$video->image_path}}" alt="..." />

                    </td>
                    <td scope="row">{{$video->title}}</td>
                    <td scope="row"style="
                    width: 200px;
                    word-wrap: break-word;
                    display: inline-block;"><a href="https://{{$video->video_url}}">{{$video->video_url}}</a></td>
                    <td scope="row">{{$video->created_at}}</td>
                    <td>
                        <a class="btn btn-sm btn-primary" href='{{route('videos.edit', [$video->id])}}'>
                         <div style="width: 60px" class="d-flex justify-content-between align-items-center">                        
                        <i class="far fa-edit" style="margin-right:5px"></i> <span>تعديل</span>
                        </div>
                        </a>
                    </td>
                    <form class="delet-element" action="{{route('videos.destroy',[$video->id])}}" method="POST">
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
        {{$videos->withQueryString()->links()}}
        
    @endif
</x-main-layout>