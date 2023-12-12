<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('users.emails.register-confirmation')
                    ->subject('Thank you for registering to SHARE App!')
                    ->from('ra_inbow@icloud.com','Your Sender Name')
                    ->with([
                        'name' => $this->details['name'],
                        'app_url' => $this->details['app_url'],
                    ]);
                
    }
}