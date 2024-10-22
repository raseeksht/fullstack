<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UserCreated implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $data)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger("A new User is created" . $this->data);
    }
}
