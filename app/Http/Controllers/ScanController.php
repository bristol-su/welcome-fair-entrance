<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanController extends Controller
{

    public function create()
    {
        return view('scan.create');
    }

    public function index()
    {
        return view('scan.index');
    }


}
