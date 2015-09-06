@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    <div class="page-wrapper">
        <div class="pagehead">
            <div class="container-fluid">
                <h1>RFI # {{ $rfi->rfi_id }} - {{ $rfi->subject }}</h1>
            </div>
        </div>
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-2"><strong>Date</strong></div>
                            <div class="col-sm-4">{{ $rfi->created_at }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Assigned To</strong></div>
                            <div class="col-sm-4">{!! link_to('mailto:'. $rfi->assignedTo->email, $rfi->assignedTo->name) !!}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Submitted To</strong></div>
                            <div class="col-sm-4">
                                <address>
                                    {{ $rfi->project->name }}<br />
                                    {{ $rfi->project->street }}<br />
                                    {{ $rfi->project->city }}, {{ $rfi->project->state }} {{ $rfi->project->zip_code }}
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Respond By</strong></div>
                            <div class="col-sm-4">{{ $rfi->due_date }}</div>
                            <div class="col-sm-2"><strong>Direct Response To</strong></div>
                            <div class="col-sm-4">{!! link_to('mailto:'. $rfi->createdBy->email, $rfi->createdBy->name) !!}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Reference</strong></div>
                            <div class="col-sm-4">{{ $rfi->references }}</div>
                            <div class="col-sm-2"><strong>Cost Impact</strong></div>
                            <div class="col-sm-4">{{ $rfi->cost_impact }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Originated From</strong></div>
                            <div class="col-sm-4">{{ $rfi->origin }}</div>
                            <div class="col-sm-2"><strong>Schedule Impact</strong></div>
                            <div class="col-sm-4">{{ $rfi->schedule_impact }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Subject</strong></div>
                            <div class="col-sm-4">{{ $rfi->subject }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Question</strong></div>
                            <div class="col-sm-4">{{ $rfi->question }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" data-toggle="modal" href="#add-comment-modal">Add Comment</a>
                    </div>
                    Comments
                </div>
                @if(count($rfi->comments) > 0)
                <ul class="list-group">
                    @foreach($rfi->comments as $comment)
                    <li class="list-group-item">
                        <div class="media">
                            <div class="media-left">
                                <img src="" alt="" />
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                </h4>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                    <div class="panel-body">
                        No Comments yet.  <a href="#add-comment-modal" data-toggle="modal">Add the first!</a>
                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection

@section('endbody')
    @parent
    <div class="modal fade" id="add-comment-modal" tabindex="-1" role="dialog" aria-labelledby="add-comment-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="add-comment-modal-label">Add a Comment</h4>
                </div>
                <div class="modal-body">
                    <textarea name="rfiComment" id="rfi-comment" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add-comment-save">Add Comment</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#add-comment-save').click(function() {
            var comment = $('#rfi-comment').val();

            if (comment.length > 0) {
                console.log('sending comment to the API');
                $.ajax("{{ route('rfis.comments.index', ['rfis' => $rfi->id]) }}/" + comment);
            }
            $('#add-comment-modal').modal('hide');
        });
    </script>
@endsection