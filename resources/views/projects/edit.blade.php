@extends('projects.partials.form')

@section('form-open')
    
    <script type="text/javascript">
        $(document).ready(function () {
            //Insert country & state
            print_country("country", "state", "{{ $project->country }}", "{{ $project->state }}");
        });
    </script>
    
    <div class="pagehead">
        <h1>Edit Project</h1>
        {{ $project->country }}
    </div>
    {!! Form::model($project, array('url' => 'projects', 'method' => 'post', 'class' => 'form-horizontal')) !!}
    {!! Form::hidden('id', $project->id) !!}
@stop

@section('form-buttons')
    {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
    {!! Html::linkRoute('projects.index', 'Cancel', null, array('class' => 'btn btn-default btn-spacer-left')) !!}
@stop