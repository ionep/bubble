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
        $consume=Consumption::orderBy('day')->where('month','11')->get();
        return view('home')->with('consume',$consume);
    }
}
