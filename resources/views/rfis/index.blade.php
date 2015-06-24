@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    <div class="page-wrapper">
        @include('rfis.partials.list-head')
        <div id="rfi-list" class="container-fluid">
            @include('rfis.partials.list')
        </div>
    </div>
@endsection