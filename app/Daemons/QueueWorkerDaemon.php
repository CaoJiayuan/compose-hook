<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2019/1/4
 * Time: 10:31
 */

namespace App\Daemons;


use Illuminate\Console\Command;
use Nerio\Daemon\Daemon;

class QueueWorkerDaemon extends Daemon
{
    /**
     * @var Command
     */
    private $command;

    /**
     * QueueWorkerDaemon constructor.
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        parent::__construct();
        $this->command = $command;
    }

    /**
     * Run your process here.
     * @return mixed
     */
    protected function runningAtBackground()
    {
        $this->command->call('queue:work', [
            '--sleep' => 3,
            '--tries' => 3,
        ]);
    }
}