@extends('layouts.application.main')
@section('content')
  <div class="pagehead">
    <h1>My Projects</h1>
    <p class="text-muted no-margin">Create & manage your projects from here.</p>
  </div>
  @include('projects.partials.project_filter')
  @include('projects.partials.project_list_tiled')
@endsection