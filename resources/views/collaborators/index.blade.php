@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    <div class="page-wrapper">
        <div class="pagehead">
            <div class="container-fluid">
                <a class="btn btn-default btn-sm pull-right btn-spacer-left" href="/collaborators/help"
                   data-target="#modal" data-toggle="modal" title="How does this work?">Help</a>
                <a class="btn btn-warning btn-sm pull-right btn-spacer-left" href="/collaborators/invite"
                   data-target="#modal" data-toggle="modal" title="Invite a person to Aecore."><span
                            class="glyphicon glyphicon-bullhorn" style="margin-right:2px;top:2px;"></span> Invite to
                    Aecore</a>
                @if($projectUser->access == \App\Models\Projectuser::ACCESS_ADMIN)
                    <a class="btn btn-success btn-sm pull-right" href="/collaborators/add" data-target="#modal"
                       data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Add Collaborators</a>
                @endif
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
                                    <span class="text-warning glyphicon glyphicon-tower pull-right small"
                                          style="top:3px;"></span>
                                @endif
                                @if($collaborator->status == \App\Models\Projectuser::STATUS_INVITED)
                                    <span class="pull-right small text-warning">{{ ucfirst($collaborator->status) }}</span>
                                @endif
                                <img src="{{ $collaborator->user->gravatar }}" class="avatar_lg"/>

                                <p style="font-size:1.2em;">{{ $collaborator->user->name }}</p>

                                <p class="text-muted small">
                                    {{ $collaborator->user->title }}
                                    @if($collaborator->user->company_user_status != 'disabled')
                                        {{ (!empty($collaborator->user->company->name) && !empty( $collaborator->user->title)) ? ' at ' . $collaborator->user->company->name : @$collaborator->user->company->name }}
                                    @endif
                                </p>

                                <p class="text-muted small">
                                    <span class="glyphicon glyphicon-envelope" style="top:2px;margin-right:3px;"></span>
                                    <a href="mailto:{!! $collaborator->user->email !!}"
                                       title="{!! $collaborator->user->email !!}">{!! $collaborator->user->email !!}</a>
                                </p>
                                @if($collaborator->user->userphone)
                                    <p class="small">
                                        <span class="glyphicon glyphicon-phone text-muted" style="top:2px;margin-right:3px;"></span>
                                        {{ $collaborator->user->userphone->mobile == null ? 'Not provided' : $collaborator->user->userphone->mobile }}
                                    </p>
                                @endif
                            </div>
                            <div class="panel-footer {{ $collaborator->panelColor }} team-tile-footer">
                                <span class="text-muted small bold">{!! @$collaborator->user->company->type !!}</span>
                                @if($projectUser->access == \App\Models\Projectuser::ACCESS_ADMIN)
                                    <div class="btn-group pull-right btn-spacer-left">
                                        
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle"data-toggle="dropdown">
                                            Manage <span class="caret"></span>
                                        </button>
                                        
                                        <ul class="dropdown-menu" role="menu">
                                            <li class="dropdown-header" role="presentation">User Roles</li>
                                            <li>
                                                <a href="#" class="make-admin small">
                                                    Administrator
                                                    @if($collaborator->access == \App\Models\Projectuser::ACCESS_ADMIN)
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    @endif
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="make-collab small">
                                                    Collaborator
                                                    @if($collaborator->access == \App\Models\Projectuser::ACCESS_COLLAB)
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    @endif
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="make-limited small">
                                                    Limited
                                                    @if($collaborator->access == \App\Models\Projectuser::ACCESS_LIMITED)
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    @endif
                                                </a>
                                            </li>
                                            
                                            @if ($collaborator->status == \App\Models\Projectuser::STATUS_ACTIVE)
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="#" class="small remove-collaborator">
                                                        <span class="glyphicon glyphicon-trash small"></span>
                                                        Remove from project
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="#" class="small read-collaborator">
                                                        <span class="glyphicon glyphicon-trash small"></span>
                                                        Re-Add to project
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
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
        (function ($, location) {
            'use strict';
            $('.make-admin').click(function () {
                updateCollaboratorAccess(this, {access: "{!! \App\Models\Projectuser::ACCESS_ADMIN !!}"});
            });
            $('.make-collab').click(function () {
                updateCollaboratorAccess(this, {access: "{!! \App\Models\Projectuser::ACCESS_COLLAB !!}"});
            });
            $('.make-limited').click(function () {
                updateCollaboratorAccess(this, {access: "{!! \App\Models\Projectuser::ACCESS_LIMITED !!}"});
            });

            $('.remove-collaborator').click(function () {
                updateCollaboratorAccess(this, {status: "{!! \App\Models\Projectuser::STATUS_DISABLED !!}"});
            });
            $('.read-collaborator').click(function () {
                updateCollaboratorAccess(this, {status: "{!! \App\Models\Projectuser::STATUS_ACTIVE !!}"});
            });

            function findCollaboratorId(context) {
                return $(context).parents('[data-collaborator-id]').attr('data-collaborator-id');
            }

            function updateCollaboratorAccess(context, newData) {
                var data = $.extend({_token: token}, newData);
                $.ajax({
                    url: "/collaborators/" + findCollaboratorId(context),
                    method: "PUT",
                    data: data,
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