<x-main-layout :title="$title">
  
        <div class="container-fluid ">
            <div class="row" style="padding-top: 20px">
              <div class="col-lg-6">
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">قسم الاخبار</h5>
                  </div>
                  <div class="card-body">
                    {{-- <h6 class="card-title">Special title treatment</h6> --}}
    
                    <p class="card-text">هنا يتم عرض واضافة الاخبار</p>
                    <a href="{{route('reports.index')}}" class="btn btn-primary">عرض سجل الأخبار</a>
                    
                  </div>
                </div>
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">قسم المقالات</h5>
                  </div>
                  <div class="card-body">
                    {{-- <h6 class="card-title">Special title treatment</h6> --}}
    
                    <p class="card-text">هنا يتم عرض واضافة مقال اليوم</p>
                    <a href="{{route('articles.index')}}" class="btn btn-primary">عرض المقالات</a>
                  </div>
                </div>
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">قسم الاعلانات</h5>
                  </div>
                  <div class="card-body">
                    {{-- <h6 class="card-title">Special title treatment</h6> --}}
    
                    <p class="card-text">هنا يتم عرض واضافة الاعلانات</p>
                    <a href="{{route('ads.index')}}" class="btn btn-primary">عرض سجل الاعلانات</a>
                    
                  </div>
                </div>
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">قسم المجالس</h5>
                  </div>
                  <div class="card-body">
                    {{-- <h6 class="card-title">Special title treatment</h6> --}}
    
                    <p class="card-text">هنا يتم عرض واضافة المجالس</p>
                    <a href="{{route('councils.index')}}" class="btn btn-primary">عرض سجل المجالس</a>
                    
                  </div>
                </div>
              </div>
              
              <!-- /.col-md-6 -->
              <div class="col-lg-6">
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0"> قسم الاعضاء</h5>
                  </div>
                  <div class="card-body">
                    {{-- <h6 class="card-title">Special title treatment</h6> --}}
    
                    <p class="card-text">هنا يتم عرض واضافة الأعضاء</p>
                    <a href="{{route('users.index')}}" class="btn btn-primary">عرض الأعضاء</a>
                  </div>
                </div>
    
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">قسم مقاطع الفيديو</h5>
                  </div>
                  <div class="card-body">
                    {{-- <h6 class="card-title">Special title treatment</h6> --}}
    
                    <p class="card-text">هنا يتم عرض واضافة مقطع اليوم</p>
                    <a href="{{route('videos.index')}}" class="btn btn-primary">عرض مقاطع الفيديو</a>
                  </div>
                </div>
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">قسم الجرائد الالكترونية</h5>
                  </div>
                  <div class="card-body">
                    {{-- <h6 class="card-title">Special title treatment</h6> --}}
    
                    <p class="card-text">هنا يتم عرض واضافة الجريدة الالكترونية</p>
                    <a href="{{route('newspapers.index')}}" class="btn btn-primary">عرض  الجرائد</a>
                    
                  </div>
                </div>
                
                
              </div>
              <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
</x-main-layout>