{{-- <div style="margin-bottom: 10px; dir:rtl" >
    <form action="{{route("$action", $id ?? '')}}" method="GET">
        <button class="btn btn-primary" >{{$label}}</button>
      </form>
</div> --}}

<div class="m-2" style=" padding:15px ;dir:rtl">
  <a class="btn" style="background: #1e2f48;color:#fff;padding: 7px;" href="{{route("$action", $id ?? '')}}">{{$label}}</a>
</div>