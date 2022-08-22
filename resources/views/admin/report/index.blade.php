<x-main-layout :title="$title">

    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <x-form-new-button label='اضافة خبر جديد' action='reports.create' />

    @if ($reports->count() == 0)
                <div class="alert alert-danger">عذرا لا يوجد أخبار</div>
    @else
        <table class="table table-striped" style="width:90%">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">الصورة</th>
                <th scope="col" >العنوان</th>
                <th scope="col" >المحتوى</th>
                <th scope="col">تاريخ الاضافة</th>
             
                <th scope="col"></th>
                
            </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)       
                    <tr>   
                        <th > {{$loop->iteration}}</th>
                        <td >
                           <img width="100px" src="{{$report->image_path}}" alt="...">
                        </td>
                        <td >{{$report->title}}</td>
                        <td class="report">{{$report->body}}</td>
                        <td>{{$report->created_at}}</td>
                        <td class="option">
                            <a  class="btn btn-sm btn-primary" href='{{route('reports.edit', [$report->id])}}'>
                                <div style="width: 60px" class="d-flex justify-content-between align-items-center">
                                    <i class="far fa-edit" style="margin-right:5px"></i> 
                                    <span>تعديل</span>
                                </div>   
                            </a>
                        </td>
                        <form class="delet-element" action="{{route('reports.destroy',[$report->id])}}" method="POST">
                            @method('delete')
                            @csrf
                            <td>
                                <button type="submit" class="btn btn-sm btn-danger"><div style="width: 55px" class="d-flex justify-content-between align-items-center"> <i class="far fa-trash-alt" style="margin-right:5px"></i> <span>حذف</span></div></button>
                            </td>
                        </form>
                    
                    </tr>
                    
                @endforeach
            </tbody>
        </table>
        {{$reports->withQueryString()->links()}}
    @endif
</x-main-layout>