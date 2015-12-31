<?php

require_once('vendor/autoload.php');

use Petun\YaSpeech\Command\SpeechGenerationCommand;
use Symfony\Component\Console\Application;

$app = new Application();
$app->add(new SpeechGenerationCommand());
$app->run();