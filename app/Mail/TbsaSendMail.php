<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TbsaSendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $contentEmails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contentEmails)
    {
        $this->contentEmails = $contentEmails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->contentEmails['subject'])
            ->view('emails.' . $this->contentEmails['email_template'])
            ->with(['contentEmails' => $this->contentEmails]);
    }
}
