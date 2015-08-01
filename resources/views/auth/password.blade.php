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
        
        <div class="panel panel-default">
            <div class="panel-body" style="padding:20px;">
                
                <h3 class="text-info" style="margin:0;">Reset Your Password.</h3>
                <h5 class="text-muted" style="margin:7px 0 15px 0;">Enter your email address and we'll send you instructions to reset your password.</h5>
                
                {!! Form::open(array('url' => 'password/email', 'method' => 'post')) !!}

                    <div class="form-group">
                        <span class="text-danger">{!! $errors->first('email') !!}</span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon-email"><span class="glyphicon glyphicon-envelope"></span></span>
                            {!!Form::text('email', null, array('class'=>'form-control input-lg', 'placeholder'=>'you@yourdomain.com', 'aria-describedby' => 'addon-email', 'autofocus' => 'true'))!!}
                        </div>
                    </div>
                    
                    <div class="form-group no-margin">
                        {!! Form::submit('Send Reset Link', array('class' => 'btn btn-block btn-lg btn-info')) !!}
                    </div>
                    
                {!! Form::close() !!}
            </div>
            
            <div class="panel-footer center">
                <span class="text-muted">First time here? {!! link_to('signup', 'Create an Account', array('class'=>'text-muted bold')) !!}</span>
            </div>
        </div>
    </div>
@endsection