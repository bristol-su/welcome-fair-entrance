<?php


namespace App\Http\Controllers;


use App\Events\UidScanUpdateRequest;
use App\Http\Controllers\Controller;
use App\Scan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UidController extends Controller
{

    public function index()
    {
        return view('uid.uid');
    }

}
