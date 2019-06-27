<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LaravelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, WithExecLines, WithSendEmail;
    private $dir;
    private $mail;
    /**
     * @var array
     */
    private $extras;
    private $service;

    /**
     * Create a new job instance.
     *
     * @param $dir
     * @param $service
     * @param $mail
     * @param array $extras
     */
    public function __construct($dir, $service, $mail, $extras = [])
    {
        $this->dir = $dir;
        $this->mail = $mail;
        $this->extras = $extras;
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        chdir($this->dir);
        $lines = [
            'git pull',
            'compose install --ignore-platform-reqs'
        ];

        $commands = array_merge($lines, $this->extras);
        $logs = $this->execLines($commands);
        array_unshift($commands, "cd {$this->dir}");

        $this->mail && $this->sendGitEmail($this->mail, "{$this->dir}:{$this->service}", $commands, $logs);
    }
}
