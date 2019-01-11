<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ComposeDeployed extends Mailable
{
    use Queueable, SerializesModels;
    private $service;
    private $url;

    /**
     * Create a new message instance.
     *
     * @param $service
     */
    public function __construct($service, $url)
    {
        $this->service = $service;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('compose', [
            'service' => $this->service,
            'url'     => $this->url
        ]);
    }
}
