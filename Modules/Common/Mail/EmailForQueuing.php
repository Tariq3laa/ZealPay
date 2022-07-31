<?php

namespace Modules\Common\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailForQueuing extends Mailable
{
    use Queueable, SerializesModels;

    private $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        $from_email = $this->details['sender_email'] ?? 'info@MoonLabSolutions.com';
        $from_name = $this->details['sender_name'] ?? 'Moon-Lab-Solutions';
        if (isset($this->details['file']))
            return $this->from($from_email, $from_name)
                ->subject($this->details['subject'])
                ->view($this->details['template_path'])
                ->attach($this->details['file'])
                ->with([
                    'data' => $this->details
                ]);
        else
            return $this->from($from_email, $from_name)
                ->subject($this->details['subject'])
                ->view($this->details['template_path'])
                ->with([
                    'data' => $this->details
                ]);
    }
}
