@extends('projects.partials.form')

@section('form-open')
    <div class="pagehead">
        <h1>Edit Project</h1>
    </div>
    {!! Form::model($project, array('url' => 'projects', 'method' => 'post', 'class' => 'form-horizontal')) !!}
    {!! Form::hidden('id', $project->id) !!}
@stop

@section('form-buttons')
    {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
    {!! Html::linkRoute('projects.index', 'Cancel', null, array('class' => 'btn btn-default btn-spacer-left')) !!}
@stop