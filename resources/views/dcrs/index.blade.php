@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    <div class="page-wrapper">
        @include('dcrs.partials.list-head')
        <div id="dcr-list" class="container-fluid">
           @include('dcrs.partials.list')
        </div>
    </div>
@endsection