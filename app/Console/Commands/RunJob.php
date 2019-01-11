<?php

namespace App\Console\Commands;

use App\Daemons\QueueWorkerDaemon;
use Illuminate\Console\Command;

class RunJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job {cmd : command (start|stop)} {--d|daemon : daemon}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $d = new QueueWorkerDaemon($this);

        if (!$this->option('daemon')) {
            $d->setForeground();
        }
        $status = 'started';

        switch ($this->argument('cmd')) {
            case 'start':
                $d->start();
                $status = 'started';
                break;
            case 'stop':
                $d->stop();
                $status = 'stopped';
                break;
            case 'status':
                $status = $d->status() ? 'started' : 'stopped';
                break;
        }

        $this->info("worker {$status}");
    }
}
