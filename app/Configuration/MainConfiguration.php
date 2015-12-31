<?php
/**
 * Created by PhpStorm.
 * User: marochkin_pe
 * Date: 30.12.2015
 * Time: 11:50
 */

namespace Petun\YaSpeech\Configuration;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class MainConfiguration implements ConfigurationInterface {

	/**
	 * Generates the configuration tree builder.
	 *
	 * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
	 */
	public function getConfigTreeBuilder() {
		$b = new TreeBuilder();
		$b->root('main')
			->children()
				->scalarNode('cacheDir')->defaultValue('cache')->end()
				->arrayNode('weather')
					->children()
						->integerNode('cityId')->min(0)->end()
						->scalarNode('composition')->end()
					->end()
				->end()
				->arrayNode('speech')
					->children()
						->scalarNode('apiKey')->end()
						->scalarNode('speaker')->end()
						->scalarNode('emotion')->end()
					->end()
				->end()
			->end();
		 return $b;
	}
}