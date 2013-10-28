#!/usr/bin/env php
<?php

require_once(__DIR__.'/vendor/autoload.php');

use Symfony\Component\Process\Process;

$commands = array(
    'phpunit',
    'phpunit -c TestsProject/app/',
);
$fail = false;

foreach ($commands as $command) {
    $process = new Process($command);
    $process->run(function ($type, $data) {
        if ('out' === $type) {
            echo $data;
        }
    });
    if (0 !== $process->getExitCode()) {
        $fail = true;
    }
}

exit($fail ? 1 : 0);