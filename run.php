<?php

require_once('vendor/autoload.php');

use Petun\YaSpeech\Command\SpeechGenerationCommand;
use Symfony\Component\Console\Application;

$app = new Application();
$app->add(new SpeechGenerationCommand());
$app->run();

/*
$configDirectories = array(__DIR__.'/app/config');
$locator = new FileLocator($configDirectories);
$config = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($locator->locate('main.yml')));
var_dump($config);

$processor = new Processor();
$processor->processConfiguration(new MainConfiguration(), [$config]);

// main app starts here
$info = new \Petun\YaSpeech\Weather\Info($config['weather']['cityId']);
$composer = new \Petun\YaSpeech\Weather\Composer($info);

$speech = new \Petun\YaSpeech\Speech\Processor(
	$config['speech']['apiKey'],
	$config['speech']['speaker'],
	$config['speech']['emotion']
);
$content = $speech->getMp3($composer->getComposition());

$fileToSave = $config['cacheDir'] . '/today_weather.mp3';
file_put_contents($fileToSave, $content);

echo "DONE!";
*/