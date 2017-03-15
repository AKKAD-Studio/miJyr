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
        <div class="flex"></div>
        <div class="px_30"></div>
        <div class="pad_0_20">
            <div class="panel panel-default">
                <div class="panel-heading">Сброс пароля</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <!--label for="email" class="col-md-4 control-label">E-Mail <span class="form-required" title="Обязательное поле">*</span></label-->

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus placeholder="E-mail">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <!--llabel for="password" class="col-md-4 control-label">Пароль <span class="form-required" title="Обязательное поле">*</span></label-->

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Пароль">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <!--llabel for="password-confirm" class="col-md-4 control-label">Повторите пароль <span class="form-required" title="Обязательное поле">*</span></label-->
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Повторите пароль">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn cur_p btn-primary">
                                Отправить
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
@endsection
