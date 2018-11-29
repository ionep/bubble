<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Consumption;

class Interfacer extends Controller
{
    public function interface(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'date' => 'required',
            'volume' => 'required'
        ]);
        $client=Client::find($request->input('id'));
        if(count($client)>0)
        { //registered client found
            
            //retrieve back the date format
            $year=(int)substr($request->input('date'),0,4);
            $month=(int)substr($request->input('date'),4,2);
            $day=(int)substr($request->input('date'),6,2);

            //verify if the date already exists
            $consume=Consumption::where('house_id',$request->input('id'))
                                    ->where('year',$year)
                                    ->where('month',$month)
                                    ->where('day',$day)
                                    ->get();
            if(count($consume)>0) //the data already exists 
            {
                echo "false";
                //echo "Data already exists";
            }
            else{
                $consumption=new Consumption();
                $consumption->house_id=$request->input('id');
                $consumption->year=$year;
                $consumption->month=$month;
                $consumption->day=$day;
                $consumption->consumption=$request->input('volume');
                $success=$consumption->save();
                if($success){
                    echo "true";
                }
                else{
                    echo "false";
                    // echo "Some unknown error";
                }
            }

        }
        else{ //no client registered with that id
            // echo "Client not found";
            echo "false";
        }
    }
}
