@extends('layouts.application.main')
@section('content')
  <div class="pagehead">
    <a href="/projects/create" type="button" class="btn btn-sm btn-success pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Project</a>
    <h1>Projects</h1>
  </div>
  @include('projects.partials.project_filter')
  @include('projects.partials.project_list_tiled')
@endsection