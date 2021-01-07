<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consumption;
use App\Client;
use App\City;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thisYear=date("Y");
        $thisMonth=date("m");
        
        //get data for all day of each month of the year
        $monthly=Consumption::orderBy('month')->where('year',$thisYear)->get();
        $prevMonth=[];
        $i=-1;
        $monthlyData=array(array());
        $months=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        foreach($monthly as $m) {
            if(!in_array($m['month'],$prevMonth)){
                $i++;
                $prevMonth[$i]=$m['month'];
                $monthlyData[$i]['month']=$months[$m['month']-1];
                $monthlyData[$i]['consumption']=$m['consumption'];
            }
            else{
                $monthlyData[$i]['consumption']+=$m['consumption'];
            }
        }

        //get data for each day of current month
        $daily=Consumption::orderBy('day')->where('month',$thisMonth)->get();
        $prevDay=[];
        $i=-1;
        $dailyData=array(array());
        foreach($daily as $d) {
            if(!in_array($d['day'],$prevDay)){
                $i++;
                $prevDay[$i]=$d['day'];
                $dailyData[$i]['day']=$d['day'];
                $dailyData[$i]['consumption']=$d['consumption'];
            }
            else{
                $dailyData[$i]['consumption']+=$d['consumption'];
            }
        }

        $yearly=Consumption::orderBy('year')->get();
        $prevYear=[];
        $i=-1;
        $yearlyData=array(array());
        foreach($yearly as $y) {
            if(!in_array($y['year'],$prevYear)){
                $i++;
                $prevYear[$i]=$y['year'];
                $yearlyData[$i]['year']=$y['year'];
                $yearlyData[$i]['consumption']=$y['consumption'];
            }
            else{
                $yearlyData[$i]['consumption']+=$y['consumption'];
            }
        }
        

        //data for cities
        $city=City::orderBy('id')->take(5)->get();
        $i=-1;
        $cityData=array(array());
        //check for top 5 cities
        foreach($city as $c)
        {
            $i++;
            $cityData[$i]['city']=$c['city'];
            $cityData[$i]['consumption']=0;
            $client=Client::where('address',$c['city'])->get();
            //select every client of each city
            foreach($client as $cl)
            {
                //select every cosumption data of each client
                $consumption=Consumption::where('house_id',$cl['house_id'])->get();
                foreach($consumption as $con)
                {
                    $cityData[$i]['consumption']+=$con['consumption'];
                }
            }
        }   

        return view('home')->with('daily',$dailyData)->with('monthly',$monthlyData)->with('yearly',$yearlyData)->with('city',$cityData);
    }
}
