<?php


namespace App\Http\View\Composers;


use Illuminate\Contracts\View\View;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class JavascriptComposer
{
    public function compose(View $view)
    {
        JavaScriptFacade::put([
            'PUSHER_KEY' => config('broadcasting.connections.pusher.key'),
            'PUSHER_CLUSTER' => config('broadcasting.connections.pusher.options.cluster')
        ]);
    }
}
