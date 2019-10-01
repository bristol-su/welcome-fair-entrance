<?php

namespace App\Console\Commands;

use App\Scan;
use App\Support\Control\Contracts\Repositories\Role as RoleRepository;
use App\Support\Control\Contracts\Repositories\User as UserRepository;
use Illuminate\Console\Command;

class UpdateControl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:control';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    /**
     * Create the event listener.
     *
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $scans = Scan::where('card_number', '!=', null)->get();
        foreach($scans as $scan) {
            dispatch(new \App\Jobs\UpdateControl($scan));
        }
    }
}
