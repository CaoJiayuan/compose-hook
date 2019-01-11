<?php

namespace App\Jobs;

use App\Mail\ComposeDeployed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ComposeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, WithExecLines;

    private $dir;
    /**
     * @var null
     */
    private $service;
    private $mail;
    /**
     * @var null
     */
    private $url;

    /**
     * Create a new job instance.
     *
     * @param $dir
     * @param null $service
     * @param $mail
     * @param null $url
     */
    public function __construct($dir, $service = null, $mail = null, $url = null)
    {
        $this->dir = $dir;
        $this->service = $service;
        $this->mail = $mail;
        $this->url = $url;
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
            'nginx -s stop'
        ];
        if ($this->service) {
            $lines[] = 'docker-compose pull ' . $this->service;
            $lines[] = 'docker-compose stop ' . $this->service;
            $lines[] = 'docker-compose rm --force ' . $this->service;
        } else {
            $lines[] = 'docker-compose pull';
            $lines[] = 'docker-compose down';
        }
        $lines[] = 'docker-compose up -d';
        $lines[] = 'systemctl start nginx';
        $this->execLines($lines);

        if ($this->mail) {
            \Mail::to($this->mail)
                ->send(new ComposeDeployed($this->service, $this->url));
        }
    }
}
