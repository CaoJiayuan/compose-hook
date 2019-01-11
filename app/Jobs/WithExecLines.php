<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2019-01-11
 * Time: 14:47
 */

namespace App\Jobs;


trait WithExecLines
{
    protected function execLines($lines)
    {
        foreach($lines as $line) {
            exec($line, $outputs);
            $log = implode(PHP_EOL, $outputs);
            info($log);
        }
    }
}
