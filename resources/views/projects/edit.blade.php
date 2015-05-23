@extends('projects.partials.form')

@section('form-open')
    {!! Form::model($project, array('url' => 'projects', 'method' => 'post', 'class' => 'form-horizontal')) !!}
    {!! Form::hidden('id', $project->id) !!}
@stop

@section('form-buttons')
    {!! Form::submit('Save Project', array('class' => 'btn btn-success')) !!}
    {!! Html::linkRoute('projects.show', 'Cancel', ['projects' => $project->id], array('class' => 'btn btn-default btn-spacer-left')) !!}
@stop