<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 2019-03-10
 * Time: 15:55
 */

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Jobs\SyncJob;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class LoadImageUrl implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    protected $ticket;

    /**
     * LoadImageUrl constructor.
     * @param $ticket
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle()
    {
        $imageName = 'image on server.jpg';
        Storage::disk('screenshots')->put($imageName, '123');
        $this->ticket->image_url = $imageName;
        $this->ticket->save();
    }
}
