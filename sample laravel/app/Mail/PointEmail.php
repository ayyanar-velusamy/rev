<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PointEmail extends Mailable
{
    use Queueable, SerializesModels;
	private $milestone;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($milestone)
    {
        $this->milestone = $milestone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$subject = 'Gained '.$this->milestone->point.' More Points';
				
	    return $this->view('email_templates.points_email')
                    ->with(['milestone' => $this->milestone])
					->subject($subject);
    }
}
