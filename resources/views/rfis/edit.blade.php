@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 col-lg-offset-2">
                    <div class="pagehead">
                        <h1><i class="fa fa-plus-circle text-success"></i> Update RFI {{ $rfi->rfi_id }}</h1>
                    </div>
                    @include('rfis.partials.form')
                </div>
            </div>
        </div>
    </div>
@endsection