 @extends('index')
 @section('content')

   <link href="/public/visual/css/templatemo-style.css" rel="stylesheet">
   <script type="text/javascript" src="/public/visual/js/templatemo-script.js"></script>

   <div class="templatemo-flex-row">
     <div class="templatemo-sidebar">
       <header class="templatemo-site-header logo"> 


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
           <li><a href="#" class="active">Раздел 1</a></li>
           <li><a href="#">Раздел 2</a></li>
           <li><a href="#">Раздел 3</a></li>
         </ul>
       </nav>
     </div>
     <!-- Main content -->
     <div class="templatemo-content col-1 light-gray-bg">
       <div class="templatemo-top-nav-container">
         <div class="tab wp_100">
             <div class="td_mid">

 

             </div>
             <div class="td_mid a_r top-nav">

                    <a href="{{ url('/logout') }}"><i class="fa fa-user-circle"></i></a>

             </div>
         </div>






       </div>
       <div class="templatemo-content-container">






       </div>
     </div>
   </div>





 @endsection
