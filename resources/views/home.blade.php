@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-2">
        @include('inc.sidenav')
    </div>
    <div class="col-md-10" id="main">
        <div class="row">
            <div class="col-md-1"></div>
            <span class="col-md-7"><p>Total Water Consumption(L.) - <?php echo "Kathmandu"; ?></p></span>
            <span class="search-bar pull-right col-md-3">
                {!! Form::open(['action' => 'SearchController@search', 'method' => 'POST']) !!}
                    <div class="form-group has-feedback">
                        {{Form::text('home_id', '', ['class' => 'form-control', 'placeholder' => 'Enter Home Id', 'autofocus'=>'true'])}}
                        <i class="glyphicon glyphicon-search form-control-feedback"></i>
                    </div>
                    {{-- {{Form::submit('Submit', ['class' => 'btn btn-primary col-md-6'])}} --}}
                {!! Form::close() !!}
            </span>
            <span class="col-md-1"></span>
        </div>
        <?php
            if (count($daily)>0){
                $day=[];
                $dayData=[];
                $i=0;
                foreach ($daily as $d){
                    $day[$i]=$d['day'];
                    $dayData[$i]=$d['consumption'];
                    $i++;
                }
            }
            if (count($monthly)>0){
                $month=[];
                $monthData=[];
                $i=0;
                foreach ($monthly as $m){
                    $month[$i]=$m['month'];
                    $monthData[$i]=$m['consumption'];
                    $i++;
                }
            }
        ?>
        <canvas id="chartOverall" style="height:80px;width:200px"></canvas>
        <div class="row">
            <div class="col-md-3 card" style="margin-right:40px;margin-left:60px">
                <p>Hourly Consumption</p>
                <canvas id="radarChart" style="height:40px;width:40px;"></canvas>
            </div>
            <div class="col-md-3 card" style="margin-right:40px;margin-left:40px">
                <p>Daily Consumption</p>
               <canvas id="smallLineChart" style="height:40px;width:40px"></canvas>
            </div>
            <div class="col-md-3 card" style="margin-right:40px;margin-left:40px">
                <p>Monthly Consumption</p>
                <canvas id="barChart" style="height:40px;width:40px"></canvas>
            </div>    
        </div>
    </div>
</div>
@endsection
