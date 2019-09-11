<?php


namespace App\Http\Controllers;


use ArkonEvent\CodeReadr\ApiClient\Client as Codereadr;
use ArkonEvent\CodeReadr\Exceptions\CodeReadrApiException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class NoCardController extends Controller
{

    public function index()
    {
        return view('nocard.nocard');
    }


}
