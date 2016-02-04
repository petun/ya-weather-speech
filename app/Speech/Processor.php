<?php
/**
 * Created by PhpStorm.
 * User: marochkin_pe
 * Date: 30.12.2015
 * Time: 12:18
 */

namespace Petun\YaSpeech\Speech;


class Processor {

	/**
	 * @var string
	 */
	private $_apiKey;

	/**
	 * @var string
	 */
	private $_speaker;

	/**
	 * @var string
	 */
	private $_emotion;


	public function __construct($apiKey, $speaker = 'jane', $emotion = 'good') {
		$this->_apiKey = $apiKey;
		$this->_speaker = $speaker;
		$this->_emotion = $emotion;
	}

	/**
	 * @param $text
	 *
	 * @return string|bool
	 */
	public function getMp3($text) {
		$qs = http_build_query(array("format" => "mp3","lang" => "ru-RU","speaker" => $this->_speaker ,"key" => $this->_apiKey,"emotion" => $this->_emotion, "text" => $text)); // параметры запроса
		$ctx = stream_context_create(array("http"=>array("method"=>"GET","header"=>"Referer: \r\n")));
		return @file_get_contents("https://tts.voicetech.yandex.net/generate?".$qs, false, $ctx); // запрос на генерацию mp3 файла
	}
} 