<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemographicsController extends Controller
{
    public function index()
    {
        return view('demographics.demographics');
    }

}
