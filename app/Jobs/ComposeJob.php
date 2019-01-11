<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ComposeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $dir;
    /**
     * @var null
     */
    private $service;

    /**
     * Create a new job instance.
     *
     * @param $dir
     * @param null $service
     */
    public function __construct($dir, $service = null)
    {
        $this->dir = $dir;
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
    }

    protected function execLines($lines)
    {
        foreach($lines as $line) {
            exec($line, $outputs);
            $log = implode(PHP_EOL, $outputs);
            info($log);
        }
    }
}
