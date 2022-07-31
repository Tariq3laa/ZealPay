<?php

namespace Modules\Common\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Modules\Common\Mail\EmailForQueuing;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $details;

    public $tries = 5;

    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        $email = new EmailForQueuing($this->details);
        Mail::to($this->details['receiver_email'])->send($email);
    }
}
