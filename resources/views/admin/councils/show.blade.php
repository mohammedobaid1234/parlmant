<x-main-layout :title="$title">
    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <x-form-new-button label="اضافة أقسام" action='sections.create' :id="$link" />

    @if ($sections->count() == 0)
                <div class="alert alert-danger">عذرا لا يوجد  أقسام</div>
    @else
        <table class="table table-striped" style="margin-bottom: 0; width:94%">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">أقسام</th>
                <td>تاريخ الانشاء</td>
                <th scope="col"></th>   
                <th></th>    
            </tr>
            </thead>
            <tbody>
                @foreach ($sections as $section)       
                    <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td><a href="{{route('council.checkChildren', $section->id)}}">{{$section->name}}</a></td>
                    <td>{{$section->created_at}}</td>
                    <td class="option">
                            <a class="btn btn-sm btn-primary" href='{{route('sections.edit', [$section->id])}}'><i class="far fa-edit" ></i> تعديل</a>
                    </td>
                    
                            <form class="delet-element" action="{{route('sections.destroy',[$section->id])}}" method="POST">
                                @method('delete')
                                @csrf
                                <td>
                                    <button type="submit" class="btn btn-sm btn-danger"> <i class="far fa-trash-alt" ></i> حذف</button>
                                </td>
                            </form>
                    
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-main-layout>