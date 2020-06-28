<?php

namespace App\Mail;

use App\ForkRepo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailMailable extends Mailable
{
    use Queueable, SerializesModels;
    protected $forkRepo;

    /**
     * Create a new message instance.
     *
     * @param ForkRepo $forkRepo
     */
    public function __construct(ForkRepo $forkRepo)
    {
        $this->forkRepo = $forkRepo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $repoUrl = $this->forkRepo;
        return $this->view('notify', compact('repoUrl'));
    }
}
