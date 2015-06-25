<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Print RFI Log</h4>
</div>
{!! Form::open(array('url' => 'pdf/rfi', 'target'=>'_blank', 'method' => 'post', 'class' => 'form-horizontal no-margin')) !!}
    <div class="modal-body">
        <p>Some filter options..</p>
    </div>
    <div class="modal-footer" style="margin:0;">
        <button type="submit" class="btn btn-info" title="Print to PDF."><span class="glyphicon glyphicon-print small"></span> Print</button>
        <button type="button" class="btn btn-default btn-spacer-left" data-dismiss="modal">Cancel</button>
    </div>
{!! Form::close() !!}