@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    <div class="page-wrapper">
        <div class="pagehead">
            <div class="container-fluid">
                <a class="btn btn-default btn-sm pull-right btn-spacer-left" href="/collaborators/help" data-target="#modal" data-toggle="modal" title="How does this work?">Help</a>
                <a class="btn btn-success btn-sm pull-right" href="/collaborators/add" data-target="#modal" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Add Collaborators</a>
                <h1>Collaborators</h1>
                <p class="text-muted no-margin">Add your project team.</p>
            </div>
        </div>
      
        <div class="container-fluid">
            <div class="row">
                @foreach($collaborators as $collaborator)
                <div class="col-sm-6 col-md-5 col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-body team-tile">
                            <img src="{{ $collaborator->user->gravatar }}" class="avatar_lg" />
                            <span class="pull-right label label-{{ $collaborator->status == \App\Models\Projectuser::STATUS_ACTIVE ? 'info' : 'danger' }}">{{ $collaborator->status }}</span>
                            <p style="font-size:1.2em;">{{ $collaborator->user->name }}</p>
                            <p class="text-muted small">
                                {{ $collaborator->user->title }}
                                {{ $collaborator->user->title . !empty($collaborator->user->company->name) ? ' at ' . $collaborator->user->company->name : '' }}
                            </p>
                            <p class="text-muted small">
                                <span class="glyphicon glyphicon-envelope" style="top:2px;"></span>
                                <a href="mailto:{!! $collaborator->user->email !!}" title="{!! $collaborator->user->email !!}">{!! $collaborator->user->email !!}</a>
                            </p>
                            @if($collaborator->user->userphone)
                                <p class="text-muted small">
                                    <span class="glyphicon glyphicon-phone" style="top:2px;"></span>
                                    {{ $collaborator->user->userphone->mobile }}
                                </p>
                            @endif
                        </div>
                        <div class="panel-footer team-tile-footer">
                            <div class="btn-group pull-right btn-spacer-left">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-user"></span> Manage <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        @if($collaborator->access != \App\Models\Projectuser::ACCESS_ADMIN)
                                            <a href="#" class="small">
                                                <span class="glyphicon glyphicon-tower"></span> Make Admin
                                            </a>
                                        @else
                                            <a href="#" class="small">
                                                <span class="glyphicon glyphicon-tower"></span> Remove Admin
                                            </a>
                                        @endif
                                    </li>
                                    @if ($collaborator->status == \App\Models\Projectuser::STATUS_ACTIVE)
                                    <li>
                                        <a href="#" class="small">
                                            <span class="glyphicon glyphicon-trash"></span> Remove
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            {{--
                            <span class="text-warning small bold pull-right btn-spacer-left" style="margin-top:4px;">
                                <span class="glyphicon glyphicon-tower"></span>
                            </span>
                            <span class="small bold pull-right text-muted">Invited</span> --}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection