<?php
/**
 * Created by PhpStorm.
 * User: marochkin_pe
 * Date: 30.12.2015
 * Time: 12:03
 */

namespace Petun\YaSpeech\Weather;


class Info {
	private $_xml;

	public function __construct($cityId) {
		$url = $url="http://export.yandex.ru/weather-ng/forecasts/".$cityId.".xml";
		$this->_xml = simplexml_load_file($url);
	}

	public function getTemperaturePrefix() {
		$temp = (int)$this->_xml->fact->temperature;
		if (preg_match('/-\d/', $temp)) {
			return '-';
		}
		return '';
	}

	public function getTown() {
		return (string)$this->_xml['city'];
	}

	public function getTemperature() {
		return abs((int)$this->_xml->fact->temperature);
	}

	public function getWeatherType() {
		return (string)$this->_xml->fact->weather_type;
	}

	public function getHumidity() {
		return (string)$this->_xml->fact->humidity;
	}

	public function getWindDirection() {
		$w = [
			'e' => 'восточный',
			'w' => 'западный',
			's' => 'южный',
			'n' => 'северный',
			'se' => 'юго-восточный',
			'ne' => 'северо-восточный',
			'sw' => 'юго-западный',
			'nw' => 'северо-западный',
		];

		$key = (string)$this->_xml->fact->wind_direction;
		return array_key_exists($key, $w) ? $w[$key] : $key;
	}

	public function getWindSpeed() {
		return $this->_xml->fact->wind_speed;
	}

	public function getPressure() {
		return $this->_xml->fact->pressure;
	}

	public function getTime() {
		return $this->_xml->fact->observation_time;
	}
}