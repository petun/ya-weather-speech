<?php
/**
 * Created by PhpStorm.
 * User: marochkin_pe
 * Date: 30.12.2015
 * Time: 16:31
 */

namespace Petun\YaSpeech\Command;


use Symfony\Component\Console\Command\Command;

class SpeechGenerationCommand extends Command {

	protected function configure() {

	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$name = $input->getArgument('name');
		if ($name) {
			$text = 'Hello '.$name;
		} else {
			$text = 'Hello';
		}

		if ($input->getOption('yell')) {
			$text = strtoupper($text);
		}

		$output->writeln($text);
	}

} 