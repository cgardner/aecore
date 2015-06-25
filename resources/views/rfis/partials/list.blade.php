<table class="table table-hover table-sortable no-margin">
    <thead>
        <th>RFI #</th>
        <th>Subject</th>
        <th>Ball in Court</th>
        <th class="tablet-hide">Initiated By</th>
        <th class="tablet-hide">Date Initiated</th>
        <th class="mobile-hide">Date Due</th>
        <th class="mobile-hide">Status</th>
    </thead>
    <tbody>
        <tr class="pointer">
            <td>1</td>
            <td>This is a sample subject line for an RFI.</td>
            <td><img src="{{ Auth::User()->gravatar }}" class="avatar_xs"/> John Smith</td>
            <td class="tablet-hide">W&W RFI-004</td>
            <td class="tablet-hide">06/20/2015</td>
            <td class="mobile-hide">06/24/2015</td>
            <td class="mobile-hide">Open</td>
        </tr>
    </tbody>
</table>

<!-- ELSE -->

<div class="alert alert-info">
    <p class="bold"><span class="glyphicon glyphicon-warning-sign"></span> No {filter} RFIs were found.</p>
    <p>Try changing your filter or create a <a href="/rfis/create" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> New RFI</a> to get started.</p>
</div>