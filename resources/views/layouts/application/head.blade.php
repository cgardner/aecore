<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Project management for construction.">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>Aecore</title>

    <!-- load js dependencies -->
    <script type="text/javascript" src="{!! asset('/js/jquery-2.1.3.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/jquery-ui/jquery-ui.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/bootstrap.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/uploadifive/jquery.uploadifive.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/jquery.quicksearch.js') !!}"></script>
    <script type="text/javascript">
        $(function(){
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>

    <!-- load css -->
    <link rel="shortcut icon" href="{!! asset('/css/img/appicons/favicon.ico') !!}">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato:300,400,700">
    <link rel="stylesheet" type="text/css" href="{!! asset('/css/bootstrap.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/css/bootstrap-mod.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/js/jquery-ui/css/jquery-ui.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/js/uploadifive/uploadifive.css') !!}">
</head>