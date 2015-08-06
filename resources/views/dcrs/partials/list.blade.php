<table class="table table-hover table-sortable no-margin">
    <thead>
        <th>Date</th>
        <th>Subject</th>
        <th>Ball in Court</th>
        <th class="tablet-hide">Initiated By</th>
        <th class="tablet-hide">Date Initiated</th>
        <th class="mobile-hide">Date Due</th>
        <th class="mobile-hide">Status</th>
    </thead>
    <tbody>
        <tr class="pointer">
            <td>06/18/2015</td>
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
    <p class="bold"><span class="glyphicon glyphicon-warning-sign"></span> No {filter} DCRs were found.</p>
    <p>Try changing your filter
        @if($projectUser->access != \App\Models\Projectuser::ACCESS_LIMITED)
            or <a href="/dcrs/create" class="bold">Create a New DCR</a> to get started.
        @endif
    </p>
</div>