<?php

namespace ExtensionRegistryHelper\Test;

use ExtensionRegistryHelper\ExtensionRegistryHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class ExtensionRegistryHelperTest
 */
class ExtensionRegistryHelperTest extends TestCase {

	/**
	 * This has to come first. Otherwise the singleton will already be stored in the static variable.
	 *
	 * @throws \Exception
	 */
	public function testGetSingletonOnInvalidEnvironment() {

		$this->expectException( \Exception::class );

		self::assertInstanceOf( ExtensionRegistryHelper::class, ExtensionRegistryHelper::singleton() );
	}

	/**
	 * @throws \Exception
	 */
	public function testGetSingleton() {

		$GLOBALS[ 'wgVersion' ] = '1.27';
		self::assertInstanceOf( ExtensionRegistryHelper::class, ExtensionRegistryHelper::singleton() );
	}


}
