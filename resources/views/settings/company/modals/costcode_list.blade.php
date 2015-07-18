<script type="text/javascript">
    function addCode() {
        $('#codelist').prepend('<tr>\n\
                <td>{!! Form::text('code[]', null, array('id'=>'newcode', 'class'=>'form-control input-sm', 'placeholder'=>'ex. 082000...', 'autofocus'=>'true')) !!}</td>\n\
                <td>\n\
                    {!! Form::text('description[]', null, array('class'=>'form-control input-sm', 'style'=>'width:95%;', 'placeholder'=>'ex. Doors & Hardware...')) !!}\n\
                </td>\n\
            </tr>');
        $('#newcode').focus();
    }
    
    $(function () {
        $('input#code_filter').quicksearch('table tbody tr');
	});
    
    function deleteCode(codeId) {
        var token = "{{ \Session::token() }}";
        var data = $.extend({_token: token}, {codeId:codeId});
        $.ajax({
            url: "/settings/company/costcodes/delete",
            method: "POST",
            data: data,
            success: function() {
                $('#row-'+codeId).remove();
            }
        });
    }
        
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Cost Codes</h4>
</div>

{!! Form::open(array('url' => 'settings/company/costcodes/update', 'method' => 'post', 'class' => 'form-horizontal no-margin')) !!}
    <div class="modal-body form-horizontal">
        @if(count($codes) > 0)
            <div class="form-group">
                <div class="col-md-7">
                    {!! Form::text('code_filter', null, array('id'=>'code_filter', 'class'=>'form-control', 'placeholder'=>'Filter by code or description...', 'autofocus'=>'true')) !!}
                </div>
                <div class="col-md-3">
                    <span class="btn btn-info" onClick="addCode();"><span class="glyphicon glyphicon-plus"></span> Add a New Code</span>
                </div>
            </div>

            <div class="form-group no-margin" id="cost-code-list">
                <div class="col-md-12">
                    <div style="max-height:450px;overflow-y:auto;border:1px solid #c9d1d6;">
                        <table id="code" class="table table-hover no-margin">
                            <thead>
                                <tr>
                                    <th style="width:30%;">Cost Code</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody id="codelist">
                                @foreach($codes as $code)
                                    <tr onmouseover="$('#trash-{!! $code->id !!}').show();" onmouseout="$('#trash-{!! $code->id !!}').hide();" id="row-{!! $code->id !!}">
                                        <td>
                                            {!! Form::text('code[]', $code->code, array('class'=>'form-control input-sm', 'placeholder'=>'ex. 082000...', 'required'=>'true', 'autofocus'=>'true')) !!}
                                        </td>
                                        <td>
                                            <i class="fa fa-trash pull-right btn-link-light" onClick="deleteCode('{!! $code->id !!}');" id="trash-{!! $code->id !!}" style="line-height:29px;margin-left:0;display:none;"></i>
                                            {!! Form::text('description[]', $code->description, array('class'=>'form-control input-sm', 'style'=>'width:95%;', 'placeholder'=>'ex. Doors & Hardware...', 'required'=>'true')) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                <p><span class="glyphicon glyphicon-warning-sign"></span> No cost codes found.</p>
            </div>
        @endif
    </div>
    <div class="modal-footer" style="margin:0;">
        {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
        <button type="button" class="btn btn-default btn-spacer-left" data-dismiss="modal">Cancel</button>
    </div>
{!! Form::close() !!}