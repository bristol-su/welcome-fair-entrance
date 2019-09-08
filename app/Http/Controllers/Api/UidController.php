<?php


namespace App\Http\Controllers\Api;


use App\Events\UidScanUpdateRequest;
use App\Http\Controllers\Controller;
use App\Scan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Twigger\UnionCloud\API\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\API\UnionCloud;

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

    public function search(Request $request, UnionCloud $unionCloud)
    {
        try {
            $result = $unionCloud->users()->search(
                $request->only(['id', 'forename', 'surname', 'email'])
            )->get();
        } catch (ResourceNotFoundException $e) {
            return [];
        }


        return collect($result->toArray())->map(function($user) {
            return $user->attributes;
        });
    }

}
