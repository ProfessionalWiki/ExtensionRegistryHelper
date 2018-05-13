<?php

namespace ExtensionRegistryHelper;


/**
 * Class ExtensionRegistryHelper
 *
 * @package ExtensionRegistryHelper
 */
class ExtensionRegistryHelper {

	private static $singleton;

	/**
	 * ExtensionRegistryHelper constructor.
	 *
	 * @throws \Exception
	 */
	public function __construct() {
		if ( version_compare( $GLOBALS[ 'wgVersion' ], '1.27', '<' ) ) {
			throw new \Exception( 'ExtensionRegistryHelper requires MediaWiki 1.27 or above.' );
		}
	}


	/**
	 * @return ExtensionRegistryHelper
	 * @throws \Exception
	 */
	public static function singleton() {
		if ( !self::$singleton ) {
			self::$singleton = new self();
		}

		return self::$singleton;
	}

	/**
	 * @param $extensionName
	 * @param null $path
	 *
	 * @throws \ReflectionException
	 */
	public function loadExtensionRecursive( $extensionName, $path = null ) {
		$path = $path ?: $GLOBALS[ 'wgExtensionDirectory' ] . '/' . $extensionName . '/extension.json';
		$this->loadModuleRecursive( $extensionName, $path );
	}

	/**
	 * @param $skinName
	 * @param null $path
	 *
	 * @throws \ReflectionException
	 */
	public function loadSkinRecursive( $skinName, $path = null ) {
		$path = $path ?: $GLOBALS[ 'wgStyleDirectory' ] . '/' . $skinName . '/skin.json';
		$this->loadModuleRecursive( $skinName, $path );
	}

	/**
	 * @param $moduleName
	 *
	 * @throws \ReflectionException
	 */
	protected function loadModuleRecursive( $moduleName, $path ) {

		$extensionRegistry = \ExtensionRegistry::getInstance();

		if ( !$extensionRegistry->isLoaded( $moduleName ) && !array_key_exists( $path, $extensionRegistry->getQueue() ) ) {

			$subregistry = new \ExtensionRegistry();
			$subregistry->load( $path );

			$loadedRefl = new \ReflectionProperty( \ExtensionRegistry::class, 'loaded' );
			$loadedRefl->setAccessible( true );
			$loadedRefl->setValue( $extensionRegistry, $extensionRegistry->getAllThings() + $subregistry->getAllThings() );

		}
	}

}