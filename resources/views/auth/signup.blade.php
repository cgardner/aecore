@extends('layouts.storefront.main')
@section('content')

    <script type="text/javascript">
        $(document).ready(function(){
             $.backstretch("{!! asset('/css/img/bg/onboarding-bg.jpg') !!}");
        });
    </script>
 
    <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4" style="padding-top:16%;">
        
        @if (Session::has('signupFailed'))
            <div class="alert alert-danger"><span class="glyphicon glyphicon-alert"></span> {!! Session::get('signupFailed') !!}</div>
        @endif

        <div class="panel panel-default">
            <div class="panel-body" style="padding:20px;">
                <h3 class="text-success" style="margin:0;">Create a new account.</h3>
                <h5 class="text-muted" style="margin:7px 0 15px 0;">It's easy and free to get started!</h5>

                {!! Form::open(array('url' => 'auth/register', 'method' => 'post')) !!}

                    <div class="form-group">
                        <span class="text-danger">{!! $errors->first('name') !!}</span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon-name"><span class="glyphicon glyphicon-user"></span></span>
                            {!!Form::text('name', null, array('class'=>'form-control input-lg', 'placeholder'=>'Full Name', 'aria-describedby' => 'addon-name', 'autofocus' => 'true'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="text-danger">{!! $errors->first('username') !!}</span>
                        <div class="input-group">
                            <span class="input-group-addon bold" style="font-size:1.2em;" id="addon-username">@</span>
                            {!!Form::text('username', null, array('class'=>'form-control input-lg', 'placeholder'=>'Username', 'aria-describedby' => 'addon-username'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="text-danger">{!! $errors->first('email') !!}</span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon-email"><span class="glyphicon glyphicon-envelope"></span></span>
                            {!!Form::text('email', null, array('class'=>'form-control input-lg', 'placeholder'=>'you@yourdomain.com', 'aria-describedby' => 'addon-email'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="text-danger">{!! $errors->first('password') !!}</span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon-password"><span class="glyphicon glyphicon-lock"></span></span>
                            {!!Form::password('password',array('class' => 'form-control input-lg', 'placeholder' => 'Password', 'aria-describedby' => 'addon-password'))!!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        {!!Form::submit('Get Started!', array('class' => 'btn btn-block btn-lg btn-success', 'title' => 'Create a new Aecore account.'))!!}
                    </div>
                    <p class="text-muted small no-margin">By creating an account on Aecore, you agree to our {!! link_to('terms', 'Terms of Service', array('class'=>'text-muted bold')) !!} and {!! link_to('privacy', 'Privacy Policy', array('class'=>'text-muted bold')) !!}.</p>
                    
                {!! Form::close() !!}
            </div>
            
            <div class="panel-footer center">
                <span class="text-muted">Already have an account? {!! link_to('login', 'Log In', array('class'=>'text-muted bold')) !!}</span>
            </div>
        </div>
    </div>
@endsection

