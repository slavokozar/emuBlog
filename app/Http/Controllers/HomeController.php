<?php

namespace App\Http\Controllers;

use App\Models\Resort;
use App\Models\Sport;
use Carbon\Carbon;
use Request;

class HomeController extends Controller
{

    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('homepage');
    }



}
