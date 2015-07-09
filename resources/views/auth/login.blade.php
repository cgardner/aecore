@extends('layouts.storefront.main')
@section('content')

    <script type="text/javascript">
        $(document).ready(function(){
             $.backstretch("{!! asset('/css/img/bg/onboarding-bg.jpg') !!}");
        });
    </script>
    
    <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4" style="padding-top:16%;">
        
        @if (Session::has('accountDeleted'))
            <script type="text/javascript" charset="utf-8">
                setTimeout(function () {
                    $("#deleteerror").fadeOut("slow");
                }, 3000);
            </script>
            <div class="alert alert-success" id="deleteerror"><span class="glyphicon glyphicon-check"></span> {!! Session::get('accountDeleted') !!}</div>
        @endif

        @if (Session::has('dangerMessage'))
            <div class="alert alert-danger"><span class="glyphicon glyphicon-alert"></span> {!! Session::get('dangerMessage') !!} <br> {!! link_to('reset', 'Forgot Password?', array('class'=>'btn-link btn-spacer-left')) !!}</div>
        @endif

        @if (Session::has('warningMessage'))
            <div class="alert alert-warning"><span class="glyphicon glyphicon-alert"></span> {!! Session::get('warningMessage') !!} </div>
        @endif
        
        <div class="panel panel-default">
            <div class="panel-body" style="padding:20px;">
                <h3 class="text-info" style="margin:0;">Log in to Aecore.</h3>
                <h5 class="text-muted" style="margin:7px 0 15px 0;">We're happy to have you back!</h5>
                {!! Form::open(array('url' => 'auth/login', 'method' => 'post')) !!}

                    <div class="form-group">
                        <span class="text-danger">{!! $errors->first('email') !!}</span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon-email"><span class="glyphicon glyphicon-envelope"></span></span>
                            {!!Form::text('email', null, array('class'=>'form-control input-lg', 'placeholder'=>'you@yourdomain.com', 'aria-describedby' => 'addon-email', 'autofocus' => 'true'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="text-danger">{!! $errors->first('password') !!}</span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon-password"><span class="glyphicon glyphicon-lock"></span></span>
                            {!!Form::password('password',array('class' => 'form-control input-lg', 'placeholder' => 'Password', 'aria-describedby' => 'addon-password'))!!}
                        </div>
                        <p class="text-muted small" style="margin:5px 0 0 0;">Did you forget your password? {!! link_to('password', 'Reset Password') !!}</p>
                    </div>
                    
                    <div class="form-group no-margin">
                        {!! Form::submit('Log In', array('class' => 'btn btn-block btn-lg btn-info')) !!}
                    </div>
                    
                {!! Form::close() !!}
            </div>
            
            <div class="panel-footer center">
                <span class="text-muted">First time here? {!! link_to('signup', 'Create an Account', array('class'=>'text-muted bold')) !!}</span>
            </div>
        </div>
    </div>
@endsection