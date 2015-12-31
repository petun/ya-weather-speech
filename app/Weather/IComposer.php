<?php
/**
 * Created by PhpStorm.
 * User: marochkin_pe
 * Date: 30.12.2015
 * Time: 12:21
 */
namespace Petun\YaSpeech\Weather;

interface IComposer
{
	public function __construct(Info $yaInfo);

	public function getComposition($format);
}