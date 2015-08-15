@if(count($dcrs) == 0)
    <div class="alert alert-info">
        <p class="bold"><span class="glyphicon glyphicon-warning-sign"></span> No Daily Reports were found.</p>
        <p>Try changing your filter
            @if($projectUser->access != \App\Models\Projectuser::ACCESS_LIMITED)
                or <a href="/dcrs/create" class="bold">Create a New Daily Report</a> to get started.
            @endif
        </p>
    </div>
@else
    <table class="table table-hover table-sortable no-margin">
        <thead>
            <th>Date</th>
            <th class="tablet-hide"></th>
            <th class="mobile-hide"></th>
        </thead>
        <tbody>
            @foreach($dcrs as $dcr)
            <tr class="pointer" onClick="document.location='{!! '/dcrs/'.$dcr->id !!}'">
                <td>{!! $dcr->date !!}</td>
                <td class="tablet-hide"></td>
                <td class="mobile-hide"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif