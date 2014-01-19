#!/usr/bin/env php
<?php

include(__DIR__ . './../vendor/autoload.php');

use PhpNamedTimeOffset\BuildOffsetsCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new BuildOffsetsCommand());
$application->run();
