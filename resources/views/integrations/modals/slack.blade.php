<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <span class="slack_rgb"></span>
</div>

{!! Form::open(array('url' => 'integrations/slack', 'method' => 'post', 'class' => 'form-horizontal no-margin')) !!}
    <div class="modal-body">
            
        <div class="form-group no-margin">
            {!! Form::label('company', 'Company', array('class' => 'col-sm-2 control-label')) !!}
            
            @if($slack != null)
                {!! Form::hidden('id', $slack->id, array('required'=>'true')) !!}
            @endif
            
            <div class="col-sm-10">
                <p class="form-control-static">
                    {!! Auth::User()->company->name !!}
                    {!! Form::hidden('company_id', Auth::User()->company->id, array('required'=>'true')) !!}
                </p>
            </div>
        </div>
            
        <div class="form-group">
            {!! Form::label('project', 'Project', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                <p class="form-control-static">
                    {!! '#' . $project->number . ' ' . $project->name !!}
                </p>
                {!! Form::hidden('project_id', $project->id, array('required'=>'true')) !!}
            </div>
        </div>
        
        <div class="form-group">
            {!! Form::label('webhook', 'Webhook', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('webhook', @$slack->webhook, array('id'=>'term', 'class'=>'form-control', 'placeholder'=>'Slack Webhook URL', 'required'=>'true')) !!}
                <p class="help-block" style="margin-bottom:0;">
                    The webhook URL provided by slack should look like this:
                    <br>
                    https://hooks.slack.com/services/...
                </p>
            </div>
        </div>
        
        <div class="form-group">
            {!! Form::label('channel', 'Channel', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('channel', $channel, array('id'=>'term', 'class'=>'form-control', 'placeholder'=>'#channel (optional)')) !!}
                <p class="help-block" style="margin-bottom:0;">
                    Enter custom channel or leave blank to use default from Slack webhook.
                </p>
            </div>
        </div>
        
        <div class="form-group no-margin">
            {!! Form::label('username', 'Post As', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('username', $username, array('id'=>'term', 'class'=>'form-control', 'placeholder'=>'Username', 'required'=>'true')) !!}
                <p class="help-block" style="margin-bottom:0;">
                    This is the username the integration will post as.
                </p>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        {!! Form::submit('Save Integration', array('class' => 'btn btn-success')) !!}
        <button type="button" class="btn btn-default btn-spacer-left" data-dismiss="modal">Cancel</button>
    </div>
{!! Form::close() !!}