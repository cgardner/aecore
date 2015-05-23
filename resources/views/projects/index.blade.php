@extends('layouts.application.main')
@section('content')
  
  <div class="pagehead">
    <a href="/projects/create" type="button" class="btn btn-sm btn-success pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Project</a>
    <h1>Projects</h1>
  </div>
  
	<div class="row">
    <div class="col-sm-9">
      <div class="panel panel-default">
        @include('projects.partials.project_list')
      </div>
    </div>
		<div class="col-md-3">
      @include('projects.partials.project_filter')
		</div>
  </div>

@endsection