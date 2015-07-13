@extends('layouts.storefront.main')
@section('content')

    <script type="text/javascript">
        $(document).ready(function(){
             $.backstretch("{!! asset('/css/img/bg/onboarding-bg.jpg') !!}");
        });
    </script>
    
    <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4" style="padding-top:16%;">
        
        @if(session('status'))
            <div class="alert alert-success">
                {!! session('status') !!}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                <span class="glyphicon glyphicon-warning-sign"></span>
                {!! session('error') !!}
            </div>
        @endif
         
        <div class="panel panel-default">
            <div class="panel-body" style="padding:20px;">
                
                <h3 style="margin:0;">Set New Password.</h3>
                <h5 class="text-muted" style="margin:7px 0 15px 0;">Enter your email address and new password.</h5>
                
                {!! Form::open(array('url' => 'password/reset', 'method' => 'post')) !!}

                    <input type="hidden" name="token" value="{{ $token }}">
                    
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
                            {!!Form::password('password', array('class' => 'form-control input-lg', 'placeholder' => 'New Password', 'aria-describedby' => 'addon-password'))!!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <span class="text-danger">{!! $errors->first('password_confirmation') !!}</span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon-confirm-password"><span class="glyphicon glyphicon-lock"></span></span>
                            {!!Form::password('password_confirmation', array('class' => 'form-control input-lg', 'placeholder' => 'Confirm New Password', 'aria-describedby' => 'addon-confirm-password'))!!}
                        </div>
                    </div>
                
                    <div class="form-group no-margin">
                        {!! Form::submit('Reset Password', array('class' => 'btn btn-block btn-lg btn-success')) !!}
                    </div>
                    
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection