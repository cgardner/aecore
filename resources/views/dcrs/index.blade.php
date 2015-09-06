@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
<style>
    body {
        overflow:hidden;
    }
</style>
    <div class="page-wrapper-short">
        @include('dcrs.partials.list-head')
        <div id="dcr-list" class="container-fluid">
           @include('dcrs.partials.list')
        </div>
    </div>
    <div class="page-wrapper-footer" id="dcrChart"></div>
    
    <script type="text/javascript">
        new Morris.Line({
          element: 'dcrChart',
          data: [
            <?php
                foreach($dcrs as $dcr) {
                    echo '{ week: \'' . date('Y-m-d', strtotime($dcr->date))  . '\', crew: ' . $dcr->crew . ', hours: ' . $dcr->hours . ' },';
                }
            ?>
          ],
          // The name of the data record attribute that contains x-values.
          xkey: 'week',
          // A list of names of data record attributes that contain y-values.
          ykeys: ['crew', 'hours'],
          // Labels for the ykeys -- will be displayed when you hover over the
          // chart.
          labels: ['Crew', 'Crew Hrs']
        });
</script>

@endsection