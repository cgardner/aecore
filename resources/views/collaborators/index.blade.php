@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    <div class="page-wrapper">
        <div class="pagehead">
            <div class="container-fluid">
                <a class="btn btn-default btn-sm pull-right btn-spacer-left" href="/collaborators/help" data-target="#modal" data-toggle="modal" title="How does this work?">Help</a>
                <a class="btn btn-success btn-sm pull-right" href="/collaborators/add" data-target="#modal" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Add Collaborators</a>
                <h1>Collaborators</h1>
                <p class="text-muted no-margin">Add your entire project team.</p>
            </div>
        </div>
      
        <div class="container-fluid">
            <div class="row">
                @foreach($collaborators as $collaborator)
                    <div class="col-sm-6 col-md-5 col-lg-3" data-collaborator-id="{{ $collaborator->id }}">
                        <div class="panel panel-default">
                            <div class="panel-body team-tile">
                                @if($collaborator->access == \App\Models\Projectuser::ACCESS_ADMIN)
                                    <span class="text-warning glyphicon glyphicon-tower pull-right small" style="top:3px;"></span>
                                @endif
                                @if($collaborator->status == \App\Models\Projectuser::STATUS_INVITED)
                                    <span class="pull-right small text-warning">{{ ucfirst($collaborator->status) }}</span>
                                @endif
                                <img src="{{ $collaborator->user->gravatar }}" class="avatar_lg" />
                                <p style="font-size:1.2em;">{{ $collaborator->user->name }}</p>
                                <p class="text-muted small">
                                    {{ $collaborator->user->title }}
                                    {{ $collaborator->user->title . !empty($collaborator->user->company->name) ? ' at ' . $collaborator->user->company->name : '' }}
                                </p>
                                <p class="text-muted small">
                                    <span class="glyphicon glyphicon-envelope" style="top:2px;margin-right:3px;"></span>
                                    <a href="mailto:{!! $collaborator->user->email !!}" title="{!! $collaborator->user->email !!}">{!! $collaborator->user->email !!}</a>
                                </p>
                                @if($collaborator->user->userphone)
                                    <p class="text-muted small">
                                        <span class="glyphicon glyphicon-phone" style="top:2px;margin-right:3px;"></span>
                                        {{ $collaborator->user->userphone->mobile }}
                                    </p>
                                @endif
                            </div>
                            <div class="panel-footer team-tile-footer">
                                <span class="bold small text-muted">{!! @$collaborator->user->company->type !!}</span>
                                <div class="btn-group pull-right btn-spacer-left">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        <span class="glyphicon glyphicon-user"></span> Manage <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            @if($collaborator->access != \App\Models\Projectuser::ACCESS_ADMIN)
                                                <a href="#" class="small make-admin">
                                                    <span class="glyphicon glyphicon-tower small"></span> Make admin
                                                </a>
                                            @else
                                                <a href="#" class="small remove-admin">
                                                    <span class="glyphicon glyphicon-tower small"></span> Revoke admin
                                                </a>
                                            @endif
                                        </li>
                                        @if ($collaborator->status == \App\Models\Projectuser::STATUS_ACTIVE)
                                        <li>
                                            <a href="#" class="small remove-collaborator">
                                                <span class="glyphicon glyphicon-trash small"></span> Remove from project
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('endbody')
    <script>
        (function($, location) {
            'use strict';
            $('.make-admin').click(function() {
                updateCollaboratorAccess(this, "{!! \App\Models\Projectuser::ACCESS_ADMIN !!}");
            });

            $('.remove-admin').click(function() {
                updateCollaboratorAccess(this, "{!! \App\Models\Projectuser::ACCESS_USER !!}");
            });

            $('.remove-collaborator').click(function() {
                removeCollaboratorAccess(this);
            });

            function findCollaboratorId(context) {
                return $(context).parents('[data-collaborator-id]').attr('data-collaborator-id');
            }

            function updateCollaboratorAccess(context, access) {
                $.ajax({
                    url: "/collaborators/" + findCollaboratorId(context),
                    method: "PUT",
                    data: {
                        access: access,
                        "_token": token
                    },
                    success: reload
                });
            }

            function removeCollaboratorAccess(context) {
                $.ajax({
                    url: "/collaborators/" + findCollaboratorId(context),
                    method: "DELETE",
                    data: {
                        "_token": token
                    },
                    success: reload
                });
            }

            function reload() {
                location.reload();
            }

            var token = "{{ \Session::token() }}";
        })(jQuery, location);
    </script>
@endsection