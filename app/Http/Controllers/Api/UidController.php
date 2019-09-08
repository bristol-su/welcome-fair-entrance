<?php


namespace App\Http\Controllers\Api;


use App\Events\UidScanUpdateRequest;
use App\Http\Controllers\Controller;
use App\Scan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UidController extends Controller
{

    public function store(Request $request)
    {
        $scan = Scan::create([
            'scanned_at' => Carbon::now()
        ]);

        event(new UidScanUpdateRequest($scan, $request->input('uid')));

        return $scan;
    }

}
