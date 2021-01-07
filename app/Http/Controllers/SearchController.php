<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Consumption;
use App\City;

class SearchController extends Controller
{
    public function search(Request $request){
        if($request->has('house_id'))
        { 
            return $this->searchHouse($request);
        }
        else if($request->has('city')){
            return $this->searchCity($request);
        }
        else{
            return redirect()->back();
        }
    }

    public function searchHouse(Request $request){
        $houseId=$request->input('house_id');
        $client=Client::where('house_id',$houseId)->get();

        if(count($client)==1){
            $thisYear=date("Y");
            $thisMonth=date("m");
            
            //get data for all day of each month of the year
            $monthly=Consumption::orderBy('month')->where('house_id',$houseId)->where('year',$thisYear)->get();
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
            $daily=Consumption::orderBy('day')->where('house_id',$houseId)->where('month',$thisMonth)->get();
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

            //get data for each year
            $yearly=Consumption::orderBy('year')->where('house_id',$houseId)->get();
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
            return view('home')->with('daily',$dailyData)->with('monthly',$monthlyData)->with('yearly',$yearlyData)->with('house_id',$houseId);
        
        }
        else
        { 
            return redirect()->back()->withErrors(['House Not Found!!', 'House Not Found']);
        }
    }

    public function searchCity(Request $request)
    {
        $city=$request->input('city');
        $thisYear=date("Y");
        $thisMonth=date("m");
        
        $cities=City::where('city',$city)->get();
        if(count($cities)==1)
        {
            $client=Client::where('address',$city)->get();
            $cityDailyLabel=array();
            $cityDailyData=array();
            $cityMonthlyLabel=array();
            $cityMonthlyData=array();
            $cityDailyLabel=array();
            $cityMonthlyData=array();
            $j=0;
            $k=0;
            $l=0;
            foreach($client as $c)
            {
                //get data for all day of each month of the year
                $monthly=Consumption::orderBy('month')->where('house_id',$c['house_id'])->where('year',$thisYear)->get();
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
                }//transfer to city variable
                if(!isset($cityMonthlyData[$k]) || !isset($cityMonthlyLabel[$k]))
                {
                   foreach($monthlyData as $m)
                   {
                       if(isset($m['consumption']) && isset($m['month'])){
                        $cityMonthlyData[$k]=$m['consumption'];
                        $cityMonthlyLabel[$k]=$m['month'];
                        $k++;
                       }
                   }
                }
                else{
                    foreach($monthlyData as $m)
                    {
                        if(in_array($m['month'],$cityMonthlyData))
                        {
                            $key=array_search($m['month'],$cityMonthlyLabel);
                            $cityMonthlyData[$key]+=$m['consumption'];
                        }
                        else{
                            $cityMonthlyLabel[$k]=$m['month'];
                            $cityMonthlyData[$k]=$m['consumption'];
                            $k++;
                        }
                    }
                }

                //get data for each day of current month
                $daily=Consumption::orderBy('day')->where('house_id',$c['house_id'])->where('month',$thisMonth)->get();
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
                }// transfer to city variable
                if(!isset($cityDailyData[$j]) || !isset($cityDailyLabel[$j]))
                {
                   foreach($dailyData as $d)
                   {
                       if(isset($d['consumption']) && isset($d['day']))
                       {
                        $cityDailyData[$j]=$d['consumption'];
                        $cityDailyLabel[$j]=$d['day'];
                        $j++;
                       }
                   }
                }
                else{
                    foreach($dailyData as $d)
                    {
                        if(in_array($d['day'],$cityDailyData))
                        {
                            $key=array_search($d['day'],$cityDailyLabel);
                            $cityDailyData[$key]+=$d['consumption'];
                        }
                        else{
                            $cityDailyLabel[$j]=$d['day'];
                            $cityDailyData[$j]=$d['consumption'];
                            $j++;
                        }
                    }
                }

                //get data for each year
                $yearly=Consumption::orderBy('year')->where('house_id',$c['house_id'])->get();
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
                }//transfer to city variable
                if(!isset($cityYearlyData[$l]) || !isset($cityYearlyLabel[$l]))
                {
                   foreach($yearlyData as $y)
                   {
                       if(isset($y['consumption']) && isset($y['year'])){
                        $cityYearlyData[$l]=$y['consumption'];
                        $cityYearlyLabel[$l]=$y['year'];
                        $l++;
                       }
                   }
                }
                else{
                    foreach($yearlyData as $y)
                    {
                        if(in_array($y['year'],$cityYearlyData))
                        {
                            $key=array_search($y['year'],$cityYearlyLabel);
                            $cityYearlyData[$key]+=$y['consumption'];
                        }
                        else{
                            $cityYearlyLabel[$l]=$y['year'];
                            $cityYearlyData[$l]=$y['consumption'];
                            $l++;
                        }
                    }
                }
                
            }
            //make a complete variable
            $cityDaily=array(array());
            for($k=0;$k<count($cityDailyData);$k++)
            {
                $cityDaily[$k]['day']=$cityDailyLabel[$k];
                $cityDaily[$k]['consumption']=$cityDailyData[$k];
            }
            $cityMonthly=array(array());
            for($k=0;$k<count($cityMonthlyData);$k++)
            {
                $cityMonthly[$k]['month']=$cityMonthlyLabel[$k];
                $cityMonthly[$k]['consumption']=$cityMonthlyData[$k];
            }
            $cityYearly=array(array());
            for($k=0;$k<count($cityYearlyData);$k++)
            {
                $cityYearly[$k]['year']=$cityYearlyLabel[$k];
                $cityYearly[$k]['consumption']=$cityYearlyData[$k];
            }
            
            return view('home')->with('daily',$cityDaily)->with('monthly',$cityMonthly)->with('yearly',$cityYearly)->with('city_name',$city);
        }
        else{
            return redirect()->back()->withErrors(['City Not Found!!', 'City Not Found']);
        }
    }
}
