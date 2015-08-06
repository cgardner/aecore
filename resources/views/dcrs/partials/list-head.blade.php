<div class="pagehead">
    <div class="container-fluid">
        <a class="btn btn-default btn-sm pull-right btn-spacer-left" href="/pdf/log/dcrs" data-target="#modal" data-toggle="modal" title="Print to PDF."><span class="glyphicon glyphicon-print"></span> Print Log</a>
        @if($projectUser->access != \App\Models\Projectuser::ACCESS_LIMITED)
            <a class="btn btn-success btn-sm pull-right" href="{{ URL::Route('dcrs.create') }}"><span class="glyphicon glyphicon-plus"></span> New DCR</a>
        @endif
        <h1>Daily Construction Reports Log</h1>
        <p class="text-muted no-margin">Create & manage DCR's from here.</p>
    </div>
</div>