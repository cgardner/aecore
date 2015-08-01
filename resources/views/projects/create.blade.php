@extends('projects.partials.form')

@section('form-open')

    <script type="text/javascript">
        $(document).ready(function () {
            //Insert country & state
            print_country("country", "state", "United States", "");
        });
    </script>
    
    <div class="pagehead">
        <h1>Create a New Project</h1>
    </div>
    {!! Form::open(array('url' => 'projects', 'method' => 'post', 'class' => 'form-horizontal')) !!}
@endsection

@section('form-buttons')
    {!! Form::submit('Create Project', array('class' => 'btn btn-success')) !!}
    {!! link_to('projects', 'Cancel', array('class' => 'btn btn-default btn-spacer-left')) !!}
@endsection