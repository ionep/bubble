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
    <?php if(Auth::user()){ ?>
    <script>
        $(document).ready(function(){
            
            var data=<?php if(isset($data)){echo json_encode($data);} ?>; //maybe check if null is returned
            var labels=<?php if(isset($date)){echo json_encode($date);} ?>;
            var chartOverallElement = document.getElementById('chartOverall').getContext('2d');
            var chart = new Chart(chartOverallElement, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "No label",
                        backgroundColor: 'transparent',
                        borderColor: 'rgb(40, 205, 243)',
                        data: data,
                        pointBackgroundColor: [],
                    }]
                },
                options: {
                    // remove label
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                    return tooltipItem.yLabel;
                            }
                        }
                    },
                    //y-axis scale
                    scales: {
                        yAxes: [{  
                            ticks: {
                            beginAtZero: true,
                            stepSize: 0.5
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                            },
                        }]
                    }
                }
            });

            //radar chart
            var radarChartElement=document.getElementById('radarChart').getContext('2d');
            var radarChart=new Chart(radarChartElement,{
                type: 'radar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "No label",
                        backgroundColor: 'transparent',
                        borderColor: 'rgb(40, 205, 243)',
                        data: data,
                        pointBackgroundColor: [],
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                    return tooltipItem.yLabel;
                            }
                        }
                    },
                }
            });

            //small line chart
            var smallChartElement = document.getElementById('smallLineChart').getContext('2d');
            var smallChart = new Chart(smallChartElement, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "No label",
                        backgroundColor: '',
                        borderColor: 'rgb(40, 205, 243)',
                        data: data,
                        pointBackgroundColor: [],
                    }]
                },
                options: {
                    // remove label
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                    return tooltipItem.yLabel;
                            }
                        }
                    },
                    //y-axis scale
                    scales: {
                        yAxes: [{  
                            ticks: {
                            beginAtZero: true,
                            stepSize: 2
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                            }
                        }]
                    }
                }
            });

            //bar chart
            var barChartElement = document.getElementById('barChart').getContext('2d');
            var barChart = new Chart(barChartElement, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "No label",
                        backgroundColor: 'rgb(40, 205, 243)',
                        borderColor: 'rgb(40, 205, 243)',
                        data: data,
                        pointBackgroundColor: [],
                    }]
                },
                options: {
                    // remove label
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                    return tooltipItem.yLabel;
                            }
                        }
                    },
                    //y-axis scale
                    scales: {
                        yAxes: [{  
                            ticks: {
                            beginAtZero: true,
                            stepSize: 2
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                            }
                        }]
                    }
                }
            });

            document.getElementById('chartOverall').height="10px";

            var i;
            for(i=0;i<=data.length;i++)
            {
                chart.data.datasets[0].pointBackgroundColor[i] = "#000000";
                radarChart.data.datasets[0].pointBackgroundColor[i] = "#000000";
            }
            chart.update();
            radarChart.update();
        });
        
    </script>
    <?php } ?>
</body>
</html>
