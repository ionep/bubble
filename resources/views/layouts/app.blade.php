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
        function getMinMax(arr) {
            let min = arr[0];
            let max = arr[0];
            let i = arr.length;

            while (i--) {
                min = arr[i] < min ? arr[i] : min;
                max = arr[i] > max ? arr[i] : max;
            }
            return { min, max };
        }
        $(document).ready(function(){
            <?php 
            if(isset($dayData) && isset($day)){ 
            ?>
                var dayData=<?php echo json_encode($dayData); ?>; //maybe check if null is returned
                var dayLabel=<?php echo json_encode($day); ?>;
                var minMax=getMinMax(dayData);
                var dayStep=Math.ceil((minMax['max']-minMax['min'])/dayData.length);
            <?php 
            } 
            else{
            ?>
                var dayData=['0'];
                var dayLabel=['0'];
                var dayStep=1;
            <?php
            }
            ?>
            
            <?php 
            if(isset($monthData) && isset($month)){ 
            ?>
                var monthData=<?php echo json_encode($monthData); ?>; 
                var monthLabel=<?php echo json_encode($month); ?>;
                var minMax=getMinMax(monthData);
                var monthStep=Math.ceil((minMax['max']-minMax['min'])/monthData.length);
            <?php 
            } 
            else{
            ?>
                var monthData=['0'];
                var monthLabel=['0'];
                var monthStep=1;
            <?php
            }
            ?>
            
            <?php 
            if(isset($yearData) && isset($year)){ 
            ?>
                var yearData=<?php echo json_encode($yearData); ?>; 
                var yearLabel=<?php echo json_encode($year); ?>;
                var minMax=getMinMax(yearData);
                var yearStep=Math.ceil((minMax['max']-minMax['min'])/yearData.length);
                <?php 
            } 
            else{
            ?>
                var yearData=['0'];
                var yearLabel=['0'];
                var yearStep=1;
            <?php
            }
            ?>

            //month to name converter
            // var months=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            // var monthLabel=new Array();
            // for(i=0;i<monthNumber.length;i++){
            //     monthLabel[i]=months[monthNumber[i]-1];
            // }

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
                            stepSize: monthStep
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
                            stepSize: dayStep
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
                    labels: yearLabel,
                    datasets: [{
                        label: "No label",
                        backgroundColor: 'rgb(40, 205, 243)',
                        borderColor: 'rgb(40, 205, 243)',
                        data: yearData,
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
                            stepSize: yearStep
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
            }
            for(i in monthData)
            {
                chart.data.datasets[0].pointBackgroundColor[i] = "#000000";
                radarChart.data.datasets[0].pointBackgroundColor[i] = "#000000";
            }
            for(i in yearData)
            {
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
