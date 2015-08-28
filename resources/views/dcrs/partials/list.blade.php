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
            <th>Weather</th>
            <th class="tablet-hide">Crew Size</th>
            <th class="tablet-hide">Comments</th>
            <th class="mobile-hide">Critical Issues</th>
        </thead>
        <tbody>
            @foreach($dcrs as $dcr)
                <tr class="pointer" onClick="document.location='{!! '/dcrs/'.$dcr->id !!}'">
                    <td style="width:15%;">{!! date('D M d, Y', strtotime($dcr->date)) !!}</td>
                    <td style="width:15%;"><i class="wi wi-{!! str_replace(' ', '', $dcr->weather) !!}"></i> {!! $dcr->weather . ' ' . $dcr->temperature . '&deg; ' . $dcr->temperature_type[0] !!}</td>
                    <td style="width:15%;" class="tablet-hide">{!! $dcr->crew !!}</td>
                    <td class="tablet-hide">{!! $dcr->comments !!}</td>
                    <td class="mobile-hide">{!! $dcr->issues !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif