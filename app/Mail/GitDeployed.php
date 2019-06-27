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
     * @var array
     */
    private $outputs;

    /**
     * Create a new message instance.
     *
     * @param $service
     * @param $commands
     * @param array $outputs
     */
    public function __construct($service, $commands, $outputs = [])
    {
        $this->service = $service;
        $this->commands = $commands;
        $this->outputs = $outputs;
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
            'commands' => $this->commands,
            'outputs'  => $this->outputs
        ]);
    }
}
