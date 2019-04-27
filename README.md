[![Latest Stable Version](https://poser.pugx.org/mediawiki/mw-extension-registry-helper/v/stable)](https://packagist.org/packages/mediawiki/mw-extension-registry-helper)
[![License](https://poser.pugx.org/mediawiki/mw-extension-registry-helper/license)](https://packagist.org/packages/mediawiki/mw-extension-registry-helper)

# MediaWiki Extension Registry Helper

The MediaWiki Extension Registry Helper is a tiny library that allows recursive 
loading of skins and extensions in MediaWiki.

## Requirements

- PHP 5.6 or later
- MediaWiki 1.27 or later

## Usage

In general dependencies on other extensions or skins should be specified in the
`extension.json` of your extension
[[1](https://www.mediawiki.org/wiki/Manual:Extension_registration#Requirements_(dependencies))].
If that is not possible (e.g. because they are conditional dependencies or
because your MediaWiki version does not support dependency requirements yet),
the methods of this helper may be used.

If your skin or extension depends on another extension, call
```php
\ExtensionRegistryHelper\ExtensionRegistryHelper::singleton()->loadExtensionRecursive( $extensionName, $pathToExtensionJson ),
```

If your skin or extension depends on another skin, call
```php
\ExtensionRegistryHelper\ExtensionRegistryHelper::singleton()->loadSkinRecursive( $skinName, $pathToSkinJson ),
```

The paths to the `extension.json`/`skin.json` file may be ommitted. In this case
a path will be generated from the extension or skin name. 

The methods of this helper class should only be called from the callback
function defined in your `extension.json`. If you call them later, e.g. from a
`SetupAfterCache` hook handler, the hook handlers of the recursively loaded
extensions may not get called.

(This is unfortunately not enforcable, as the respective property of
ExtensionRegistry is not exposed.)

Be aware that this helper only ensures that extensions/skins are loaded. Due to
the inner workings of the `ExtensionRegistry` it cannot enforce loading in the
correct order. Particularly, if an extension or skin you depend on is already
queued for loading, it will not be advanced in the queue to be available.
This will commonly happen when both your extension and the extension it depends 
on are loaded from `LocalSettings.php`, but in the wrong order.


## License

Copyright 2018, Stephan Gambke

[GNU General Public License, version 3](https://www.gnu.org/copyleft/gpl.html) (or any later version)
