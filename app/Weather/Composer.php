<?php
/**
 * Created by PhpStorm.
 * User: marochkin_pe
 * Date: 30.12.2015
 * Time: 12:19
 */

namespace Petun\YaSpeech\Weather;


use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Translator;

class Composer implements IComposer
{

	protected $_info;

	public function __construct(Info $yaInfo) {
		$this->_info = $yaInfo;
	}

	public function getComposition() {
		$tr = new Translator('ru_RU');
		$tr->addLoader('array', new ArrayLoader());
		$tr->addResource('array', [
			'degree|degree|degrees' => 'градус|градуcа|градусов',
			'percent' => 'процент|процента|процентов',
			'mills' => 'миллиметр|миллиметра|миллиметров',
		], 'ru_RU');

		$text = $tr->transChoice('degree|degree|degrees', $this->_info->getTemperature());
		$humidity_text = $tr->transChoice('percent', $this->_info->getHumidity());
		$pressure_text = $tr->transChoice('mills', $this->_info->getPressure());

		$tempPrefixText = $this->_info->getTemperaturePrefix() == '-' ? 'минус' : 'плюс';

		return "Сейчас в городе ".$this->_info->getTown() ." ".$this->_info->getWeatherType(). ". Tемпература воздуха ".$tempPrefixText." ".$this->_info->getTemperature()." ".$text.". Влажность ".$this->_info->getHumidity()." ".$humidity_text.". Ветер ".$this->_info->getWindDirection()." ".$this->_info->getWindSpeed()." метров в секунду. Атмосферное давление ".$this->_info->getPressure()." ".$pressure_text." !";
	}
} 