<?php

namespace App\Listeners;

use App\Events\ServiceStored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Controllers\BonusController;

class WriteMessageToFile
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserLoggedIn  $event
     * @return void
     */
    public function handle(ServiceStored $event)
    {
        $bonusController = new BonusController($event->service);
        $bonusController->handleBonus();

        Storage::prepend('serviceactivity.txt', "Auto-handled Bonus Service du ".$event->service->pretty_date. " ".$event->service->date_type);
    }
}
