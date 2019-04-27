<?php
namespace ExtensionRegistryHelper\Test;

use ExtensionRegistryHelper\ExtensionRegistryHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class ExtensionRegistryHelperTest
 */
class ExtensionRegistryHelperTest extends TestCase {

	/**
	 * @throws \Exception
	 */
	public function testGetSingleton(){

		$GLOBALS[ 'wgVersion' ] = '1.27';
		$helper = ExtensionRegistryHelper::singleton();
		self::assertInstanceOf( ExtensionRegistryHelper::class, $helper );
	}

}
