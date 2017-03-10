
@extends('index')
@section('content')


            <div class="px_30"></div>
            <div class="pad_0_20">
              <div class="panel panel-default">
                <div class="panel-heading">Регистрация</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Имя пользователя <span class="form-required" title="Обязательное поле">*</span></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-mail <span class="form-required" title="Обязательное поле">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Пароль <span class="form-required" title="Обязательное поле">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Повторите пароль <span class="form-required" title="Обязательное поле">*</span></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="g-recaptcha" data-sitekey="6LeqBRcUAAAAACcuM1c_I3QijtlLaTr5rwtBXIDq"></div>
                            </div>
                            @if ($errors->has('g-recaptcha-response'))
                                <div class="a_c error">
                                     Ошибка прохождения теста на человечность!<br /> Докажите, что Вы не робот...
                                </div>
                            @endif
                        </div>


                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary cur_p">
                                    Зарегистрироваться
                                </button>
                            </div>
                    </form>
                </div>
            </div>
            <a href="{{ url('/login') }}"><div class="mw_400 div_c"><div class="btn cur_p btn-sec">Войти</div></div></a>




 @endsection
