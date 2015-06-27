<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Invite Your Team to Aecore</h4>
</div>
<!-- Add collaborator form -->
<div id="collab_form">
    {!! Form::open(array('url' => 'collaborators/invite', 'method' => 'post', 'class' => 'form-horizontal no-margin')) !!}
        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', 'Name', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('name', null, array('id'=>'term', 'class'=>'form-control', 'placeholder'=>'Full Name', 'required'=>'true', 'autofocus'=>'true')) !!}
                </div>
            </div>
            <div class="form-group no-margin">
                {!! Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::email('email', null, array('id'=>'term', 'class'=>'form-control', 'placeholder'=>'Email Address', 'required'=>'true')) !!}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            {!! Form::submit('Send Invite', array('class' => 'btn btn-success')) !!}
            <button type="button" class="btn btn-default btn-spacer-left" data-dismiss="modal">Cancel</button>
        </div>
    {!! Form::close() !!}
</div>