<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        //Find users
        var NoResultsLabel = "No results found.";
        $('#term').autocomplete({
          source: function(request, response) {    
            $.ajax({ url: "/autocomplete/users",
              data: {term: $("#term").val()},
              dataType: "json",
              type: "POST",
              success: function(data){
                if(!data.length){
                  var result = [{
                    label: NoResultsLabel,
                    title: '',
                    value: response.term,
                    avatar: ''
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
              $("#term").val(ui.item.label);
            }
            return false; // Prevent the widget from inserting the value.
          },
          change: function (event, ui) {
            if(!ui.item){
              $(event.target).val("");
            }
          },
          select: function(event, ui) {
            if (ui.item.label === NoResultsLabel) {
              $(event.target).val("");
            } else {
                $(".panel").show();
              $('#collaborator-list').append('\n\
                <div class="usertag" id="collab_tag_' + ui.item.usercode + '" style="margin-top:6px;">\n\
                    ' + ui.item.avatar + '\n\
                    <span>' + ui.item.label + '</span>\n\
                    <span class="usertag-remove" style="margin-top:8px;"><span class="glyphicon glyphicon-remove-sign" onClick="$(\'#collab_tag_' + ui.item.usercode + '\').remove();$(\'#collab_' + ui.item.usercode + '\').remove();" title="Remove from invite."></span></span>\n\
                </div>');
              $('#collaborator-list-data').append('<input type="hidden" id="collab_' + ui.item.usercode + '" name="usercode[]" value="' + ui.item.usercode + '" />');
              $(event.target).val("");
            }
            return false;// Prevent the widget from inserting the value.
          }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $('<li></li>')
            .append('<a>' + item.avatar + '<span class="bold" style="margin:0 0 2px 0;">' + item.label + '</span><br><span class="text-muted small" style="margin:0;">' + item.title + '</span>' )
            .appendTo(ul);
          };
    });
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Add Collaborators</h4>
</div>
<!-- Add collaborator form -->
<div id="collab_form">
    {!! Form::open(array('url' => 'collaborators/add', 'method' => 'post', 'class' => 'form-horizontal no-margin')) !!}
        <div class="modal-body">
            <div class="form-group" style="margin-bottom:10px;">
                <div class="col-lg-12">
                    {!! Form::text('term', null, array('id'=>'term', 'class'=>'form-control', 'placeholder'=>'Add collaborators...', 'autofocus')) !!}
                </div>
            </div>
            <div class="panel panel-default no-margin" style="display:none;max-height:260px;overflow-y:auto;">
                <div class="panel-body" id="collaborator-list" style="padding:5px 10px 10px 10px;"></div>
                <div id="collaborator-list-data"></div>
            </div>
            <p style="font-size:1em;margin:5px 0 0 0;" class="text-muted small">Can't find who you're looking for? <span class="btn-link" onClick="toggle_collab();">Invite to Aecore</span></p>
        </div>
        <div class="modal-footer">
            {!! Form::submit('Add Collaborators', array('class' => 'btn btn-success')) !!}
            <button type="button" class="btn btn-default btn-spacer-left" data-dismiss="modal">Cancel</button>
        </div>
    {!! Form::close() !!}
</div>