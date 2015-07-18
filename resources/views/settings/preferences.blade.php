@extends('layouts.application.main')
@section('content')
<div class="pagehead">
    <h1>Settings / Company / Preferences</h1>
</div>
<div class="row">
    <div class="col-sm-4 col-md-3">
        @include('settings.nav')
    </div>
    <div class="col-sm-8 col-md-9">  
        @if(Session::has('UpdateSuccess'))
            <script type="text/javascript" charset="utf-8">
                setTimeout(function () {
                    $("#deletesuccess").fadeOut("slow");
                }, 2500);
            </script>
            <div class="alert alert-success" id="deletesuccess"><span class="glyphicon glyphicon-ok"></span> {!! Session::get('UpdateSuccess') !!}</div>
        @endif
        
        @if(Session::has('UpdateError'))
            <script type="text/javascript" charset="utf-8">
                setTimeout(function () {
                    $("#deleteError").fadeOut("slow");
                }, 2500);
            </script>
            <div class="alert alert-danger" id="deleteError"><span class="glyphicon glyphicon-warning-sign"></span> {!! Session::get('UpdateError') !!}</div>
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">Preferences</div>
            <div class="panel-body">
                @include('settings.company.costcodes')
            </div>
        </div>
    </div>
</div>
@stop