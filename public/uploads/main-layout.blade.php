<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en" dir="rtl">
<head>
  <meta charset="utf-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{$title}}</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{asset('assets/admin/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/adminlre.min.css')}}">
  <link href="{{asset('assets/alert/css/style.css')}}" type="text/css" rel="stylesheet">
  <link href="{{asset('assets/alert/css/sweetalert.css')}}" type="text/css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{asset('assets/alert/js/sweetalert.min.js')}}" type="text/javascript"></script>
  <style>
    body{
      font-size: 14px;
      background: #333;
    }
    .main-index{
      padding-top: 10px;
      box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
    }
    .content-wrapper {
    background: #eee;
  }
  .option{
    width: 10%;
  }
  
  .report {
    display: inline-block;
    width: 15%;
    width:200px;
    height: 75px;
    /* white-space: nowrap; */
    overflow: hidden;
    text-overflow: ellipsis; 
  }
  
  /* .report th:first-of-type{
    width: 5%;
  } */
  .content{
    margin-right: 15px;
    width: 95%;
    background: #fff;
    padding: 10px;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
    }
    .shap {
      display: flex;
      width: 80%;
    }
    .shap div{
      display: flex;
      flex-direction: column;
      padding: 10px;
    }
    .shap h6{
      margin-bottom: 10px
    }
    .shap p{
      height: 47px;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    table{
      padding: 10px;
      /* width:90%; */
      

    }
    form{
      padding: 10px
    }
    .sidebar .user-panel .image {
      padding-right: 0px;
    }
    .sidebar::-webkit-scrollbar-thumb {
    background-color: transparent !important;
}

 
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" >
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home.index')}}" class="nav-link">الرئيسة</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        {{-- <a href="#" class="nav-link">الرجوع</a> --}}
      </li>
    </ul>

    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background:rgb(30 ,47 ,72); padding-top:40px">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link" style="display: flex; flex-direction:column; align-items:center">
      <img style="width: 3.1rem" src="{{asset('uploads/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">بارلمانات</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" >
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="display: flex; flex-direction:column; align-items:center">
        <div class="image">
          <img  style="width:5.1rem; border-radius:45%" src="{{ Auth::user()->image_path }}" class="" alt="User Image">
        </div>
        <div class="info">
          <a href="" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder=" البحث عن العضو" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="" style="margin-top:20px " >
        
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <x-dropdown-link :href="route('home.index')" class="nav-link active">
              <i class="fas fa-home"></i>

               <p>الصفحة الرئيسة</p> 
              </x-dropdown-link>
          </li>
          
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                الأقسام 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('users.index')}}" class="nav-link @if (Route::is('users.*'))
                    {{'active'}}
                @endif">
                  <i class="fas fa-users"></i>
                  <p>قسم الأعضاء</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('councils.index')}}" class="nav-link @if (Route::is('councils.*')
                   || Route::is('sections.*')) 
                
                  {{'active'}}
                @endif">
                  <i class="fas fa-users"></i>
                  <p>قسم المجالس</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('reports.index')}}" class="nav-link @if (Route::is('reports.*'))
                   {{'active'}}
                @endif">
                  <i class="fas fa-newspaper"></i>
                  <p>قسم الأخبار</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('articles.index')}}" class="nav-link @if (Route::is('articles.*'))
                  {{'active'}}
                @endif">
                  <i class="fas fa-file-pdf"></i>
                  <p>قسم المقالات</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('videos.index')}}" class="nav-link @if (Route::is('videos.*'))
                  {{'active'}}
                @endif">
                  <i class="fab fa-youtube" style="color:#f00"></i>
                  <p>قسم مقاطع الفيديو</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('newspapers.index')}}" class="nav-link @if (Route::is('newspapers.*'))
                {{'active'}}
              @endif">
                  <i class="fas fa-file-pdf"></i>
                  <p>قسم الجرائد الالكترونية</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}"  >
              @csrf
              
              <x-dropdown-link :href="route('logout')" class="nav-link "
              onclick="event.preventDefault();
                                  this.closest('form').submit();">
              <i class="fas fa-sign-out-alt"></i>

               <p>تسجيل خروج</p> 
              </x-dropdown-link>
          </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0" style="color:#1e2f48">{{$title}}</h1> 
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              {{-- <form action="{{route($btnAction)}}" method="GET">
                @csrf
                <button class="btn btn-primary" >{{$btn}}</button>
              </form> --}}
              {{-- <li class="breadcrumb-item"><a href="#">الصفحة الرئيسية</a></li>
              @if(isset($_SERVER['HTTP_REFERER']))
              <li class="breadcrumb-item active"><a href="">الرجوع</a></li>
              @endif --}}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      {{$slot}}
    </div>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
  
    </div>
    <!-- Default to the left -->
    <strong> &copy; 2021-2022 <a > جميع الحقوق محفوظة لدى بارلمانات </a></strong> 
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('assets/admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/admin/js/adminlte.min.js')}}"></script>
<script src="{{asset('js/alert.js')}}"></script>
<script src="{{asset('js/user-type.js')}}"></script>

</body>
</html>
