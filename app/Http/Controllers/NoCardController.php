<?php


namespace App\Http\Controllers;


use ArkonEvent\CodeReadr\ApiClient\Client as Codereadr;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class NoCardController extends Controller
{

    public function index()
    {
        return view('nocard.index');
    }

    public function create()
    {
        return view('nocard.create');
    }

    public function store(Request $request, Client $client, Codereadr $codeReadr)
    {
        $request->validate([
            'uid' => 'required'
        ]);

        $response = $client->get('https://barcode.codereadr.com/api/?section=barcode&action=generate&api_key='.config('codereadr.key').'&value='.$request->input('uid'));

        $codeReadr->request(Codereadr::SECTION_DATABASES, 'addvalue', [
            'database_id' => config('codereadr.database_id'),
            'value' => $request->input('uid')
        ]);

        return Response::make(base64_encode($response->getBody()->getContents()), 200, [
            'content-type' => 'image/png'
        ]);
    }
}
