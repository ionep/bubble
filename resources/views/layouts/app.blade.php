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

            var dayData=<?php if(isset($dayData)){echo json_encode($dayData);} ?>; //maybe check if null is returned
            var dayLabel=<?php if(isset($day)){echo json_encode($day);} ?>;


            var monthData=<?php if(isset($monthData)){echo json_encode($monthData);} ?>; 
            var monthNumber=<?php if(isset($month)){echo json_encode($month);} ?>;

            //month to name converter
            var months=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var monthLabel=new Array();
            for(i=0;i<monthNumber.length;i++){
                monthLabel[i]=months[monthNumber[i]-1];
                console.log(monthLabel[i]);
            }

            var chartOverallElement = document.getElementById('chartOverall').getContext('2d');
            var chart = new Chart(chartOverallElement, {
                type: 'line',
                data: {
                    labels: monthLabel,
                    datasets: [{
                        label: "No label",
                        backgroundColor: 'transparent',
                        borderColor: 'rgb(40, 205, 243)',
                        data: monthData,
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
                            stepSize: 5
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
                    labels: dayLabel,
                    datasets: [{
                        label: "No label",
                        backgroundColor: 'transparent',
                        borderColor: 'rgb(40, 205, 243)',
                        data: dayData,
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
                    labels: dayLabel,
                    datasets: [{
                        label: "No label",
                        backgroundColor: '',
                        borderColor: 'rgb(40, 205, 243)',
                        data: dayData,
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
                    labels: monthLabel,
                    datasets: [{
                        label: "No label",
                        backgroundColor: 'rgb(40, 205, 243)',
                        borderColor: 'rgb(40, 205, 243)',
                        data: monthData,
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
            for(i=0;i<=dayData.length;i++)
            {
                smallChart.data.datasets[0].pointBackgroundColor[i] = "#000000";
                radarChart.data.datasets[0].pointBackgroundColor[i] = "#000000";
            }
            for(i in monthData)
            {
                chart.data.datasets[0].pointBackgroundColor[i] = "#000000";
                barChart.data.datasets[0].pointBackgroundColor[i] = "#000000";
            }
            chart.update();
            radarChart.update();
            smallChart.update();
            barChart.update();
        });
        
    </script>
    <?php } ?>
</body>
</html>
