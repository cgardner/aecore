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
        <th>Actions</th>
    </thead>
    <tbody>
        @foreach($rfis as $rfi)
        <tr class="pointer" data-rfi-id="{{ $rfi->id }}">
            <td>{!! link_to_route('rfis.show', $rfi->rfi_id, ['rfis' => $rfi->id]) !!}</td>
            <td>{!! link_to_route('rfis.show', $rfi->subject, ['rfis' => $rfi->id]) !!}</td>
            <td>
                <img src="{{ $rfi->assignedTo->gravatar }}" class="avatar_xs"/> {{ $rfi->assignedTo->name }}
            </td>
            <td class="tablet-hide">{{ $rfi->references }}</td>
            <td class="tablet-hide">{{ $rfi->created_at }}</td>
            <td class="mobile-hide">{{ $rfi->due_date }}</td>
            <td class="mobile-hide">{{ is_null($rfi->deleted_at) ? 'Open' : 'Closed' }}</td>
            <td>
                <div class="btn-group">
                    {!! link_to_route('rfis.show', 'View', ['rfis' => $rfi->id], ['class' => 'btn btn-primary btn-sm']) !!}
                    {!! link_to_route('rfis.edit', 'Edit', ['rfis' => $rfi->id], ['class' => 'btn btn-default btn-sm']) !!}
                </div>
            </td>
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
