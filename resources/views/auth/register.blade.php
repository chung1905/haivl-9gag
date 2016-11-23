@extends('layouts.app')

@section('title')
    Register
@endsection

@section('head')
    <link href="/css/custom.css" rel="stylesheet">
    @if(!empty(env('FB_APPID')))
        <script>
            fbInit(document, 'script', 'facebook-jssdk', '{{env("FB_APPID")}}');
        </script>
    @endif
    @if(!empty(env('GG_APPID')))
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <meta name="google-signin-client_id" content="{{ env('GG_APPID') }}">
    @endif
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

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
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

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
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-12 col-md-offset-2">Or Signin with Social Account</label>
                        </div>
                        <div class="row">
                            @if (!empty(env('FB_APPID')))
                                <div class="col-md-4 col-md-offset-2">
                                    <button class="btn btn-primary fb-btn" onclick="fbSignIn()">Facebook</button>
                                </div>
                            @endif
                            <div class="col-md-4 col-md-offset-2">
                                <div class="g-signin2" data-onsuccess="ggSignIn"></div>
                            </div>
                        </div>
                        <div class="row">
                            <p id="pls-wait" class="col-md-12 col-md-offset-4"></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
