<?php

namespace App;

use App\Events\ScanCreated;
use App\Events\ScanUpdated;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{

    protected $dispatchesEvents = [
        'saved' => ScanUpdated::class,
    ];

    protected $fillable = [
        'card_number',
        'scanned_at'
    ];

    protected $casts = [
        'committee_member' => 'boolean',
        'scanned_at' => 'timestamp'
    ];
}
