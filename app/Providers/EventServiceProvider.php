<?php

namespace App\Providers;

use App\Events\ScanCreated;
use App\Events\ScanUpdateRequest;
use App\Events\UidScanUpdateRequest;
use App\Listeners\AddToUnionCloud;
use App\Listeners\FindUidFromLibraryCard;
use App\Listeners\UpdateScanDemographics;
use App\Listeners\UpdateUidScanControl;
use App\Listeners\UpdateUidScanDemographics;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\LogScanRequest;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UidScanUpdateRequest::class => [
            UpdateUidScanControl::class,
            UpdateUidScanDemographics::class,
            AddToUnionCloud::class
        ],
        ScanUpdateRequest::class => [
            FindUidFromLibraryCard::class,
	    LogScanRequest::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
