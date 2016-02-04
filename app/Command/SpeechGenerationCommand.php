<?php
/**
 * Created by PhpStorm.
 * User: marochkin_pe
 * Date: 30.12.2015
 * Time: 16:31
 */

namespace Petun\YaSpeech\Command;


use Petun\YaSpeech\Configuration\MainConfiguration;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SpeechGenerationCommand extends Command
{

	private $_config = [];

	protected function initialize(InputInterface $input, OutputInterface $output) {
		$output->writeln('Get and check configuration');

		try {
			$configDirectories = array(__DIR__ . '/../../config');
			$locator = new FileLocator($configDirectories);
			$this->_config = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($locator->locate('main.yml')));

			$processor = new Processor();
			$processor->processConfiguration(new MainConfiguration(), [$this->_config]);

		} catch (Exception $e) {
			$output->writeln('<error>' . $e->getMessage() . '</error>');
		}

		$output->writeln('Init OK');

		if ($output->isDebug())
			$output->writeln('Config is ' . print_r($this->_config, true));
	}

	protected function configure() {
		$this
			->setName('speech:weather')
			->setDescription('get weather from yandex and save it to cache');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln('Get weather info from yandex. CityId = ' . $this->_config['weather']['cityId']);
		$info = new \Petun\YaSpeech\Weather\Info($this->_config['weather']['cityId']);
		$composer = new \Petun\YaSpeech\Weather\Composer($info);

		if ($output->isDebug())
			$output->writeln('Generated text is ' . $composer->getComposition($this->_config['weather']['composition']));

		$output->writeln('Send text to yandex speech');
		$speech = new \Petun\YaSpeech\Speech\Processor(
			$this->_config['speech']['apiKey'],
			$this->_config['speech']['speaker'],
			$this->_config['speech']['emotion']
		);

		$content = $speech->getMp3($composer->getComposition($this->_config['weather']['composition']));

		if ($content) {
			$fileToSave = $this->_config['cacheDir'] . '/today_weather.mp3';

			$output->writeln('Save to file - ' . $fileToSave);
			$bytes = file_put_contents($fileToSave, $content);

			if ($output->isDebug())
				$output->writeln('Write ' . $bytes . ' bytes');

		} else {
			$output->writeln('Error while download file');
		}



	}

} 