<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GitDeployed extends Mailable
{
    use Queueable, SerializesModels;
    private $service;
    private $commands;

    /**
     * Create a new message instance.
     *
     * @param $service
     * @param $commands
     */
    public function __construct($service, $commands)
    {
        $this->service = $service;
        $this->commands = $commands;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('git', [
            'service'  => $this->service,
            'commands' => $this->commands
        ]);
    }
}
