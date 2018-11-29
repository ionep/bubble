@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-2 text-center">
        @include('inc.sidenav')
    </div>
    <div class="col-md-10">
        <span class="search-bar">
            {!! Form::open(['action' => 'SearchController@search', 'method' => 'POST']) !!}
                <div class="form-group">
                    {{Form::text('home_id', '', ['class' => 'form-control', 'placeholder' => 'Enter Home Id', 'autofocus'=>'true'])}}
                </div>
                {{-- {{Form::submit('Submit', ['class' => 'btn btn-primary col-md-6'])}} --}}
            {!! Form::close() !!}
        </span>
        <?php
            if (count($consume)>0){
                $date=[];
                $data=[];
                $i=0;
                foreach ($consume as $c){
                    $date[$i]=$c['day'];
                    $data[$i]=$c['consumption'];
                    $i++;
                }
            }
        ?>
        <canvas id="chartOverall"></canvas>
    </div>
</div>
@endsection
