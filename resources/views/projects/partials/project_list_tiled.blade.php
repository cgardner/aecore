<script type="text/javascript">
    $(document).ready(function () {
        $('input#search').quicksearch('div#project-search');
    });
</script>


@if(empty($projectUsers))
    <div class="alert alert-info">
        <p><span class="glyphicon glyphicon-exclamation-sign"></span> <strong>No projects were found using the "{{ Session::get('projectFilter') }}" filter.</strong></p>
        <p>Try changing your filter or <a href="/projects/create" class="bold">Create a New Project</a> to get started.</p>
    </div>
@else
    <div class="row">
        @foreach($projectUsers as $projectUser)
            <div class="col-lg-4 col-md-6" id="project-search">
                <div class="panel panel-default">
                    <div class="panel-body" style="padding:12px;">
                        <div class="btn-group pull-right btn-spacer-left">
                            <span class="glyphicon glyphicon-chevron-down btn-link-light" data-toggle="dropdown"></span></span>
                            <ul class="dropdown-menu" role="menu">
                                @if($projectUser->access == App\Models\Projectuser::ACCESS_ADMIN)
                                    <li>
                                        <a href="{!! URL::route('projects.edit', ['project' => $projectUser->project->id]) !!}" class="small">
                                            <i class="fa fa-pencil-square-o fa-fw"></i> Edit project
                                        </a>
                                    </li>
                                    <li>
                                        <a class="small" href="/integrations/slack/{{ $projectUser->project->id }}" data-target="#modal" data-toggle="modal">
                                            <i class="fa fa-slack fa-fw"></i> Slack integration
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                @endif
                                <li>
                                    <a href="#" class="small remove-collaborator">
                                        <i class="fa fa-sign-out fa-fw"></i> Leave project
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <h4 class="no-margin">{!! link_to_route('projects.show', '#' . $projectUser->project->number . ' ' . $projectUser->project->name, ['project' => $projectUser->project->id]) !!}</h4>

                        <p class="small text-muted" style="margin-top:5px;">
                            {{ $projectUser->project->street }}<br>
                            {{ $projectUser->project->city . ', ' . $projectUser->project->state . ' ' . $projectUser->project->zip_code }}
                        </p>

                        <span class="small text-muted">
                            <span class="glyphicon glyphicon-user small text-muted"></span>
                            {{ $projectUser->project->collabCount }}
                        </span>
                        <span class="small text-muted btn-spacer-left">
                            <span class="glyphicon glyphicon-usd small text-muted"></span>
                            {{ $projectUser->project->value ? number_format($projectUser->project->value, 0, '.', ',') : 'N/A' }}
                        </span>
                        <span class="small text-muted btn-spacer-left">
                            <span class="glyphicon glyphicon-home small text-muted"></span>
                            {{ $projectUser->project->size ? number_format($projectUser->project->size, 0, '.', ',') . ' ' . $projectUser->project->size_unit : 'N/A' }}
                        </span>
                        @if($projectUser->access == App\Models\Projectuser::ACCESS_ADMIN)
                            <span class="glyphicon glyphicon-tower text-warning small pull-right" style="margin-top:3px;"></span>
                        @endif
                    </div>
                    <div class="panel-footer text-muted" style="background:#fff;padding:5px 12px;">
                        {{ $projectUser->project->status }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@if(!empty($projectUsers))
    @section('endbody')
        <script>
            (function ($, location) {
                'use strict';
                $('.remove-collaborator').click(function () {
                    updateCollaboratorAccess(this, {status: "{!! \App\Models\Projectuser::STATUS_DISABLED !!}"});
                });

                function updateCollaboratorAccess(context, newData) {
                    var data = $.extend({_token: token}, newData);
                    $.ajax({
                        url: "/collaborators/" + {{ $projectUser->user->id }},
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
@endif