<?php

namespace App\Jobs;

use App\ForkRepo;
use App\Mail\SendEmailMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ForkRepoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $forkRepo;

    /**
     * Create a new job instance.
     * @param ForkRepo $forkRepo
     */
    public function __construct(ForkRepo $forkRepo)
    {
        $this->forkRepo = $forkRepo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to('thanhngau199@gmail.com')->send(new SendEmailMailable($this->forkRepo));
    }
}
