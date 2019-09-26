<?php

namespace App\Http\Controllers\Api;

use App\Events\UidScanUpdateRequest;
use App\Scan;
use ArkonEvent\CodeReadr\ApiClient\Client as Codereadr;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class QrCodeController
{
    public function redeem(Request $request)
    {
        $scan = Scan::create([
            'scanned_at' => Carbon::now()
        ]);

        event(new UidScanUpdateRequest($scan, $request->input('tid')));

        return Response::make(
            '<?xml version="1.0" encoding="UTF-8"?><xml><message><status>1</status><text>Success! Enjoy the Welcome Fair!</text></message></xml>',
            200,
            ['content-type' => 'application/xml']
        );
    }

    public function store(Request $request, Client $client, Codereadr $codeReadr)
    {
        $request->validate([
            'uid' => 'required'
        ]);

        $response = $client->get('https://barcode.codereadr.com/api/?section=barcode&action=generate&api_key='.config('codereadr.key').'&value='.$request->input('uid'));

        return Response::make(base64_encode($response->getBody()->getContents()), 200, [
            'content-type' => 'image/png'
        ]);
    }
}
