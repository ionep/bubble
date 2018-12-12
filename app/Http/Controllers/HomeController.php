<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consumption;

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
        foreach($monthly as $m) {
            if(!in_array($m['month'],$prevMonth)){
                $i++;
                $prevMonth[$i]=$m['month'];
                $monthlyData[$i]['month']=$m['month'];
                $monthlyData[$i]['consumption']=$m['consumption'];
            }
            else{
                $monthlyData[$i]['consumption']+=$m['consumption'];
            }
        }

        //get data for each day of current month
        $daily=Consumption::orderBy('day')->where('month',$thisMonth)->get();
        
        return view('home')->with('daily',$daily)->with('monthly',$monthlyData);
    }
}
