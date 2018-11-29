<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @if(Auth::guest())
            @include('inc.navbar')
        @endif
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var data=<?php if(isset($data)){echo json_encode($data);} ?>;
        var labels=<?php if(isset($date)){echo json_encode($date);} ?>;
        var chartOverallElement = document.getElementById('chartOverall').getContext('2d');
        var chart = new Chart(chartOverallElement, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Overall data",
                    backgroundColor: 'transparent',
                    borderColor: 'rgb(255, 99, 132)',
                    data: data,
                }]  
            },
            options: {}
        });
    </script>
</body>
</html>
