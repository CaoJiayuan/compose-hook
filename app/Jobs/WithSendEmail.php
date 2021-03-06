<?php namespace App\Jobs;

use App\Mail\ComposeDeployed;
use App\Mail\GitDeployed;

/**
 * @author caojiayuan
 */
trait WithSendEmail
{

    public function sendGitEmail($email, $service, $commands = [], $outputs = [])
    {
        $emails = explode(',', $email);
        foreach ($emails as $email) {
            \Mail::to($email)
                ->queue(new GitDeployed($service, $commands, $outputs));
        }
    }

    public function sendComposeEmail($mail, $service, $url)
    {
        \Mail::to($mail)
            ->queue(new ComposeDeployed($service, $url));
    }
}
