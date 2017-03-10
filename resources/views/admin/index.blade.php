 @extends('index')
 @section('content')

   <link href="/public/admin/css/templatemo-style.css" rel="stylesheet">
   <script type="text/javascript" src="/public/admin/js/templatemo-script.js"></script>

   <div class="templatemo-flex-row">
     <div class="templatemo-sidebar">
       <header class="templatemo-site-header">
         <div class="square"></div>
         <h1>  название</h1>
       </header>
       <div class="profile-photo-container">




         <div class="profile-photo-overlay"></div>
       </div>
       <!-- Search box -->



       <div class="mobile-menu-icon a_c">
           <i class="fa fa-bars"></i>
       </div>
       <nav class="templatemo-left-nav">
         <ul>
           <li><a href="#" class="active"><i class="fa fa-home"></i>Раздел 1</a></li>
           <li><a href="#"><i class="fa fa-bar-chart"></i>Раздел 2</a></li>
           <li><a href="#"><i class="fa fa-map"></i>Раздел 3</a></li>
         </ul>
       </nav>
     </div>
     <!-- Main content -->
     <div class="templatemo-content col-1 light-gray-bg">
       <div class="templatemo-top-nav-container">
         <div class="tab wp_100">
             <div class="td_mid">

                 <div class="row">
                   <nav class="templatemo-top-nav col-lg-12 col-md-12">
                     <ul class="text-uppercase">
                       <li><a href="" class="active">Раздел 1</a></li>
                       <li><a href="">Раздел 2</a></li>
                       <li><a href="">Раздел 3</a></li>
                     </ul>
                   </nav>
                 </div>

             </div>
             <div class="td_mid a_r top-nav">

                    <a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Выход</a>

             </div>
         </div>






       </div>
       <div class="templatemo-content-container">






       </div>
     </div>
   </div>





 @endsection
