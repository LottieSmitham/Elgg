<?php

namespace Elgg\Cache\Config;

use Phpfastcache\Drivers\Files\Config;

/**
 * Configuration for files fastcache driver
 *
 * @internal
 * @since 4.2
 */
class Files extends Config {
	
	/**
	 * Factory to return a config object to be used when starting a driver
	 *
	 * @param string       $namespace cache namespace
	 * @param \Elgg\Config $config    Elgg configuration
	 *
	 * @return self|NULL
	 */
	public static function fromElggConfig(string $namespace, \Elgg\Config $config): ?self {
		
		$path = $config->cacheroot ?: $config->dataroot;
		if (!$path) {
			return null;
		}
		
		return new self([
			'path' => $path . 'fastcache' . DIRECTORY_SEPARATOR, // make a separate folder for fastcache caches
			'defaultChmod' => 0770,
			'preventCacheSlams' => true,
			'useStaticItemCaching' => true,
			'itemDetailedDate' => true,
			'securityKey' => $namespace, // to make sure cli and webserver use the same folder and to separate caches
		]);
	}
}
