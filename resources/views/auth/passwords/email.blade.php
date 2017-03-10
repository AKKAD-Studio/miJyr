@extends('index')
<!-- Main Content -->
@section('content')

        <div class="px_30"></div>
        <div class="pad_0_20">
            <div class="panel panel-default">
                <div class="panel-body">
                  <div class="panel-heading">Восстановление пароля</div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">

                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn cur_p btn-primary">
                                Восстановить пароль
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection
