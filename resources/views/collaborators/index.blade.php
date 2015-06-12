@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    <div class="page-wrapper">
        <div class="pagehead">
            <div class="container-fluid">
                <a class="btn btn-default btn-sm pull-right btn-spacer-left" href="/collaborators/help" data-target="#modal" data-toggle="modal" title="How does this work?">Help</a>
                <h1>Collaborators</h1>
                <p class="text-muted no-margin">Add your project team.</p>
            </div>
        </div>
      
        <div class="container-fluid">
            <div class="row">
                <!-- FOREACH -->
                <div class="col-sm-6 col-md-5 col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-body team-tile">
                            <img src="{!! Auth::user()->gravatar !!}" class="avatar_lg" />
                            <p><a href="/profile" style="font-size:1.2em;">John Smith</a></p>
                            <p class="text-muted small bold">Project Engineer at South Bay Construction</p>
                            <p class="text-muted small">anthony@aecore.com</p>
                            <p class="text-muted small">(408)123-4567</p>
                        </div>
                        <div class="panel-footer team-tile-footer">
                            <div class="btn-group pull-right btn-spacer-left">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Manage <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" class="small"><span class="glyphicon glyphicon-tower"></span> Make Admin</a></li>
                                    <li><a href="#" class="small"><span class="glyphicon glyphicon-trash"></span> Remove</a></li>
                                </ul>
                            </div>
                            <span class="text-warning small bold pull-right btn-spacer-left" style="margin-top:4px;"><span class="glyphicon glyphicon-tower"></span></span>
                            <span class="small bold pull-right text-muted">Invited</span>
                        </div>
                    </div>
                </div>
                <!-- END FOREACH -->
            </div>
        </div>
    </div>
@endsection