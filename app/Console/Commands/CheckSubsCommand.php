<?php

namespace App\Console\Commands;

use App\Jobs\CheckDistrict;
use App\Subscription;
use Illuminate\Console\Command;

/**
 * Class KeyGenerateCommand
 * @package App\Console\Commands
 */
class CheckSubsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:slots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Check subscriptions";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $districts = Subscription::select('district')->distinct()->get();
        
        foreach($districts as $district){
            dispatch(new CheckDistrict($district->district));
        }

    }

}