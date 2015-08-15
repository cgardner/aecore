@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
  <div class="page-wrapper">
    <div class="container-fluid">
        <div class="pagehead">
            <h1>Daily Construction Report</h1>
        </div>
        {!! $dcr->date !!}
        {!! $dcr->weather !!}
        {!! $dcr->temperature !!}
        {!! $dcr->temperature_type !!}
        {!! $dcr->comments !!}
        {!! $dcr->correspondence !!}
        {!! $dcr->issues !!}
        {!! $dcr->safety !!}
    </div>
  </div>
@endsection
