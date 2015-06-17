<script type="text/javascript">
    $(document).ready(function(){
        
        /*
         * 
         * 
         * THIS NEEDS TO BE UPDATED
         * ADD AUTOCOMPELTE FUNCTION IN AutocompleteController
         * 
         * 
         */
        
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
                    file: ''
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
              $('#collaborator-list').append('<div class="user_tile pull-left" id="collab_tag_' + ui.item.identifier + '">' + ui.item.avatar + '<span class="glyphicon glyphicon-remove" onClick="$(\'#collab_tag_' + ui.item.identifier + '\').remove();$(\'#collab_' + ui.item.identifier + '\').remove();" title="Remove"></span><p class="line1">' + ui.item.label + '</p><p class="line2">' + ui.item.title + '</p></div>');
              $('#collaborator-list-data').append('<input type="hidden" id="collab_' + ui.item.identifier + '" name="user[]" value="' + ui.item.identifier + '" />');
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
    <div class="modal-body">
        <div class="panel panel-default no-margin">
            <div class="panel-heading" style="padding:0;">
                {!! Form::text('term', null, array('id'=>'term', 'class'=>'form-control', 'placeholder'=>'Invite users to this project...', 'style'=>'border-radius:0;border:none;', 'autofocus')) !!}
            </div>
            <div class="panel-body">
                {!! Form::open(array('id'=>'add_team_form', 'url' => 'team/add', 'method' => 'post', 'class' => 'form-horizontal no-margin')) !!}
                    dev: tags here, i.e.:
                    <div class="usertag" id="" style="margin-top:6px;">
                        <img src="{!! Auth::user()->gravatar !!}" />
                        <span>{!! Auth::user()->name !!}</span>
                        <span class="usertag-remove" style="margin-top:8px;"><span class="glyphicon glyphicon-remove-sign" onClick="$('#assigned_to').hide();$('#assigned_to_new').show();$('#term').focus();" title="Remove user & reassign task."></span></span>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-spacer-left" data-dismiss="modal">Cancel</button>
    </div>
</div>