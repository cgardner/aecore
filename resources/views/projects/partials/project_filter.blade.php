<script type="text/javascript">
  $(document).ready(function(){
    $("#project_size_text").html("0 - 50000"); //set default size
    $("#project_size_slider").slider({
      range:true,
      min:0,
      max:50000,
      values:[0,50000],
        slide: function( event, ui ) {
          $("#project_size_text").html(ui.values[0] + " - " + ui.values[1]);
        }
    });
    
    $("#project_value_text").html("$10000 - $1000000"); //set default value
    $("#project_value_slider").slider({
      range:true,
      min:0,
      max:1000000,
      values:[10000,1000000],
        slide: function( event, ui ) {
          $("#project_value_text").html("$" + ui.values[0] + " - $" + ui.values[1]);
        }
    });
    
  });
</script>

<div class="panel panel-default">
  <div class="panel-heading">
    <span class="btn-link pull-right" onClick="">Reset All</span>
    Filters
  </div>
  <div class="panel-body" style="padding:10px 15px;">
    <div class="form-group">
      {!! Form::label('project_search', 'Search', array('class' => 'control-label small bold', 'style'=>'margin:0;')) !!}
      {!! Form::text('project_search', null, array('class' => 'form-control', 'placeholder' => 'Project name...' )) !!}
    </div>
    
    <div class="form-group">
      {!! Form::label('project_status', 'Project Status', array('class' => 'control-label small bold', 'style'=>'margin:0;')) !!}
      {!! Form::select('start_type', array(
          'Bid' => 'Bid',
          'Pre-construction' => 'Pre-construction',
          'Under Construction' => 'Under Construction',
          'Close Out' => 'Close Out',
          'Archived' => 'Archived'
        ), null, array('class'=>'form-control'))
      !!}
    </div>
    
    <div class="form-group">
      {!! Form::label('project_size_text', 'Project Size', array('class' => 'control-label small bold', 'style'=>'margin:0;')) !!}
      <p class="text-danger" id="project_size_text" style="margin-bottom:5px;"></p>
      <div class="slider" id="project_size_slider"></div>
    </div>
    
    <div class="form-group no-margin">
      {!! Form::label('project_value_text', 'Project Value', array('class' => 'control-label small bold', 'style'=>'margin:0;')) !!}
      <p class="text-danger" id="project_value_text" style="margin-bottom:5px;"></p>
      <div class="slider" id="project_value_slider"></div>
    </div>
    
    <!--
    <div class="form-group">
      {!! Form::label('start_type', 'Date Range', array('class' => 'control-label small bold')) !!}
      <div class="form-inline">
        <div class="form-group">
          {!! Form::select('start_type', array(
              'start_before' => 'Start Before',
              'start_after' => 'Start After'
            ), null, array('class'=>'form-control input-sm', 'style'=>'width:50%;'))
          !!}
          {!! Form::text('start_date', null, array('class' => 'form-control input-sm', 'style'=>'width:48%;', 'placeholder' => 'Date' )) !!}
        </div>
      </div>
    </div>
    
    <div class="form-group">
      <div class="form-inline">
        <div class="form-group">
          {!! Form::select('finish_type', array(
              'finish_before' => 'Finish Before',
              'finish_after' => 'Finish After'
            ), null, array('class'=>'form-control input-sm', 'style'=>'width:50%;'))
          !!}
          {!! Form::text('finish_date', null, array('class' => 'form-control input-sm', 'style'=>'width:48%;', 'placeholder' => 'Date' )) !!}
        </div>
      </div>
    </div>
    -->
    
  </div>
</div>