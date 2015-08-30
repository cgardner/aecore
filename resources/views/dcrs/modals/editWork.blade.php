<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
    $(document).ready(function(){
        
        //Format crew hours
        $('#crew_hours_input_edit').blur(function() {
            $('#crew_hours_input_edit').currency({decimals: 1});
        });
            
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        //Find users
        var NoResultsLabel = "No results found.";
        $('#crew_company_input_edit').autocomplete({
        source: function(request, response) {    
          $.ajax({ url: "/autocomplete/companies",
            data: {term: $("#crew_company_input_edit").val()},
            dataType: "json",
            type: "POST",
            success: function(data){
              if(!data.length){
                var result = [{
                  label: NoResultsLabel,
                  value: response.term,
                  location: '',
                  logo: ''
                }];
                 response(result);
               } else {
                response(data);
              }
            }
          });
        },
        minLength:1,
        focus: function(event, ui) {
          if (ui.item.label === NoResultsLabel) {
            event.preventDefault();
          } else {
            $("#crew_company_input_edit").val(ui.item.label);
          }
          return false; // Prevent the widget from inserting the value.
        },
        select: function(event, ui) {
          $("#crew_company_input_edit").val(ui.item.label);
          return false; // Prevent the widget from inserting the value.
        }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $('<li></li>')
                .append('<a>' + item.logo + '<span class="bold" style="margin:0;">' + item.label + '</span><br><span class="light" style="margin:0;">' + item.location + '</span></a>' )
                .appendTo(ul);
        };
    });
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Edit Work</h4>
</div>
<!-- Add collaborator form -->
<div id="collab_form">
    {!! Form::open(array('id' => 'editWorkForm', 'method' => 'post', 'class' => 'form-horizontal no-margin')) !!}
        <div class="modal-body">
            <!-- Edit Work Today -->
            <div class="form-group no-margin">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="crew_company_input_edit" placeholder="Company" value="{!! $dcrWork->crew_company !!}" />
                        </div>
                        <div class="col-sm-3 mobile-margin-end">
                            <input type="number" class="form-control" id="crew_size_input_edit" min="0" step="1" placeholder="Crew size" value="{!! $dcrWork->crew_size !!}"/>
                        </div>
                        <div class="col-sm-3 mobile-margin-end">
                            <input type="number" class="form-control" id="crew_hours_input_edit" min="0" step="0.5" placeholder="Hours" value="{!! $dcrWork->crew_hours !!}"/>
                        </div>
                        <div class="col-sm-12" style="margin-top:10px;">
                            {!! Form::textarea('crew_work_input_edit', $dcrWork->crew_work, array('id' => 'crew_work_input_edit', 'class' => 'form-control', 'rows' => '4', 'placeholder' => 'Work performed today...' )) !!}
                            {!! Form::hidden('crew_id[]', $dcrWork->id, array('id' => 'crew_id_input_edit','required'=>'true' )) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="text-danger pull-left" style="margin-top:4px;display:none;" id="workError_edit">*All fields are required.</span>
            <span class="btn btn-success" onClick="editWork('{!! $dcrWork->id !!}');"><i class="fa fa-save"></i> Save</span>
            <button type="button" class="btn btn-default btn-spacer-left" data-dismiss="modal">Cancel</button>
        </div>
    {!! Form::close() !!}
</div>