<div class="pagehead">
    <div class="container-fluid">
        <a class="btn btn-default btn-sm pull-right btn-spacer-left" href="/pdf/log/rfis" data-target="#modal" data-toggle="modal" title="Print to PDF."><span class="glyphicon glyphicon-print"></span> Print Log</a>
        @if($projectUser->access != \App\Models\Projectuser::ACCESS_LIMITED)
            <a class="btn btn-success btn-sm pull-right" href="{{ URL::Route('rfis.create') }}"><span class="glyphicon glyphicon-plus"></span> New RFI</a>
        @endif
        <h1>Request for Information</h1>
        <p class="text-muted no-margin">Manage & distribute RFI's from here.</p>
    </div>
</div>