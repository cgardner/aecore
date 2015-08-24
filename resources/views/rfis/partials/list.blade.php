@if (count($rfis))
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
        @foreach($rfis as $rfi)
        <tr class="pointer" data-rfi-id="{{ $rfi->id }}">
            <td>{!! link_to_route('rfis.show', $rfi->id, ['rfis' => $rfi->id]) !!}</td>
            <td>{!! link_to_route('rfis.show', $rfi->subject, ['rfis' => $rfi->id]) !!}</td>
            <td>
                <a href="{{ route('rfis.show', ['rfis' => $rfi->id]) }}">
                    <img src="{{ $rfi->assignedTo->gravatar }}" class="avatar_xs"/> {{ $rfi->assignedTo->name }}
                </a>
            </td>
            <td class="tablet-hide">{!! link_to_route('rfis.show', $rfi->references, ['rfis' => $rfi->id]) !!}</td>
            <td class="tablet-hide">{!! link_to_route('rfis.show', $rfi->created_at, ['rfis' => $rfi->id]) !!}</td>
            <td class="mobile-hide">{!! link_to_route('rfis.show', $rfi->due_date, ['rfis' => $rfi->id]) !!}</td>
            <td class="mobile-hide">{!! link_to_route('rfis.show', is_null($rfi->deleted_at) ? 'Open' : 'Closed', ['rfis' => $rfi->id]) !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">
    <p class="bold"><span class="glyphicon glyphicon-warning-sign"></span> No RFIs were found.</p>
    <p>Try changing your filter
        @if($projectUser->access != \App\Models\Projectuser::ACCESS_LIMITED)
            or {!! link_to_route('rfis.create', 'Create a new RFI', [], ['class' => 'bold']) !!} to get started.
        @endif
    </p>
</div>
@endif
