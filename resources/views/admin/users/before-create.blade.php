<x-main-layout title=" اختر المجلس">
   
    <ul class="list-group">
    @foreach ($councils as $key => $value)
         <li class="list-group" style="font-size: 25px; padding:10px"><a href="{{route('users.create', $key)}}">{{$value}}</a></li>
    @endforeach
    </ul>
</x-main-layout>
