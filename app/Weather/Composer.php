<?php
/**
 * Created by PhpStorm.
 * User: marochkin_pe
 * Date: 30.12.2015
 * Time: 12:19
 */

namespace Petun\YaSpeech\Weather;

use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

class Composer implements IComposer
{

	protected $_info;

	public function __construct(Info $yaInfo) {
		$this->_info = $yaInfo;
	}

	public function getComposition($format) {
		$data = $this->_getChunks();

		foreach ($data as $key => $text) {
			$format = str_replace('%'.$key.'%', $text, $format);
		}

		return $format;
	}

	private function _getChunks() {
		$tr = new Translator('ru_RU');
		$tr->addLoader('array', new ArrayLoader());
		$tr->addResource('array', [
			'degree|degree|degrees' => 'градус|градуса|градусов',
			'percent' => 'процент|процента|процентов',
			'mills' => 'миллиметр|миллиметра|миллиметров',
			'hour' => 'час|часа|часов',
			'minute' => 'минута|минуты|минут',
		], 'ru_RU');

		$text = $tr->transChoice('degree|degree|degrees', $this->_info->getTemperature());
		$humidity_text = $tr->transChoice('percent', $this->_info->getHumidity());
		$pressure_text = $tr->transChoice('mills', $this->_info->getPressure());

		$tempPrefixText = $this->_info->getTemperaturePrefix() == '-' ? 'минус' : '';
		$time = date_parse($this->_info->getTime());
		$timeStr = $time['hour'] . ' ' . $tr->transChoice('hour', $time['hour']). ' ' . $time['minute'] .' ' . $tr->transChoice('minute', $time['minute']);


		$chunks = [
			'town' => $this->_info->getTown(),
			'temp' => $tempPrefixText." ".$this->_info->getTemperature()." ".$text,
			'type' => $this->_info->getWeatherType(),
			'humidity' => $this->_info->getHumidity()." ".$humidity_text,
			'wind' => $this->_info->getWindDirection()." ".$this->_info->getWindSpeed()." метров в секунду",
			'pressure' => $this->_info->getPressure()." ".$pressure_text,
			'time' => $timeStr
		];

		return $chunks;
	}
} 