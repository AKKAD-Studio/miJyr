 

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
 
