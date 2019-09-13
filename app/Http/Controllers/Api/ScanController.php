<?php


namespace App\Http\Controllers\Api;


use App\Events\ScanUpdateRequest;
use App\Http\Controllers\Controller;
use App\Scan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScanController extends Controller
{

    public function store(Request $request)
    {
        $scan = Scan::create([
            'card_number' => $request->input('card_number'),
            'scanned_at' => ($request->has('scanned_at')?Carbon::createFromFormat('d/m/Y H:i', $request->input('scanned_at')):Carbon::now())
        ]);

        event(new ScanUpdateRequest($scan));

        return $scan;
    }

    public function index(Request $request)
    {
        return Scan::paginate(300);
    }

}
