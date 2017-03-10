
@extends('index')
@section('content')
            <div class="px_30"></div>
            <div class="pad_0_20">
              <div class="panel panel-default">
                <div class="panel-heading">Вход</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <!--div class="form-group">
                            <label class="col-md-4 control-label">Войти с помощью:</label>

                            <div class="col-md-6">

                                <div id="rwSocial">

                                    <a data-soc="vkontakte" class="rwLoginBut" onclick="yaCounter23073376.reachGoal('reg-vkontakte'); mixStat('reg-vkontakte')" title="ВКонтакте" href="/app/vkontakte/login/" target="_blank"><b>ВКонтакте</b></a>
                                    <a data-soc="facebook" class="rwLoginBut" onclick="yaCounter23073376.reachGoal('reg-facebook'); mixStat('reg-facebook')" title="Facebook" href="/app/facebook/login/" target="_blank"><b>Facebook</b></a>
                                    <a data-soc="odnoklassniki" class="rwLoginBut" onclick="yaCounter23073376.reachGoal('reg-odnoklassniki'); mixStat('reg-odnoklassniki')" title="Одноклассники" href="/app/odnoklassniki/login/" target="_blank"><b>Одноклассники</b></a>
                                    <a data-soc="google" class="rwLoginBut" onclick="yaCounter23073376.reachGoal('reg-google'); mixStat('reg-google')" title="Google+" href="/app/google/login/" target="_blank"><b>Google+</b></a>
                                    <a data-soc="mailru" class="rwLoginBut" onclick="yaCounter23073376.reachGoal('reg-mailru'); mixStat('reg-mailru')" title="Mail.ru" href="/app/mailru/login/" target="_blank"><b>Mail.ru</b></a>
                                    <a data-soc="twitter" class="rwLoginBut" onclick="yaCounter23073376.reachGoal('reg-twitter'); mixStat('reg-twitter')" title="Twitter" href="/app/twitter/login/" target="_blank"><b>Twitter</b></a>
                                    <a data-soc="yandex" class="rwLoginBut" onclick="yaCounter23073376.reachGoal('reg-yandex'); mixStat('reg-yandex')" title="Яндекс" href="/app/yandex/login/" target="_blank"><b>Яндекс</b></a>
                                    <a data-soc="instagram" class="rwLoginBut" onclick="yaCounter23073376.reachGoal('reg-instagram'); mixStat('reg-instagram')" title="Instagram" href="/app/instagram/login/" target="_blank"><b>Instagram</b></a>
                                    <a data-soc="linkedin" class="rwLoginBut" onclick="yaCounter23073376.reachGoal('reg-linkedin'); mixStat('reg-linkedin')" title="LinkedIn" href="/app/linkedin/login/" target="_blank"><b>LinkedIn</b></a>
                                    <a data-soc="youtube" class="rwLoginBut" onclick="yaCounter23073376.reachGoal('reg-youtube'); mixStat('reg-youtube')" title="Youtube" href="/app/youtube/login/" target="_blank"><b>Youtube</b></a>

                                </div>


                            </div>
                        </div-->
 




                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-mail <span class="form-required" title="Обязательное поле">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
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
                            <label class="cur_p" id="remember_label">
                              <div class="tab">
                                <div class="td_mid">
                                  <input type="checkbox" id="remember_checkbox" class="disp_n" name="remember" checked>
                                  <span class="checkbox_span"></span>
                                </div>
                                <div class="td_mid form-group-label">
                                  &nbsp; Оставаться в системе
                                </div>
                              </div>
                            </label>
                        </div>

                      </div>
                      <div class="col-md-6 col-md-offset-4"><button type="submit" class="btn cur_p btn-primary">Войти</button></div>

                            @if ($errors->has('email'))
                                <div class="big a_c error">
                                    {!! $errors->first('email') !!}
                                </div>
                            @endif

                    </form>
                </div>
            </div>
            <a href="{{ url('/register') }}"><div class="mw_400 div_c"><div class="btn cur_p btn-sec">Зарегистрироваться</div></div></a>
            <div class="a_c">
                <a class="btn btn-link" href="{{ url('/password/reset') }}">Восстановить Пароль</a>
            </div>





 @endsection
