
<?php

/**
 * JCH Optimize - Aggregate and minify external resources for optmized downloads
 * 
 * @author Samuel Marshall <sdmarshall73@gmail.com>
 * @copyright Copyright (c) 2010 Samuel Marshall
 * @license GNU/GPLv3, See LICENSE file
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */


defined('_JCH_EXEC') or die('Restricted access');


class JchOptimizePagecache
{

	/**
	 *
	 *
	 */
	public static function initialize()
	{
		if (self::isCachingEnabled())
		{
			$html = JchPlatformCache::getCache(self::getPageCacheId(), true);

			if ($html !== false)
			{
				if (JCH_DEBUG)
				{
					$tag = '<!-- Cached by JCH Optimize --> </body>';
					$html = str_replace('</body>', $tag, $html);
				}

				echo $html;
				while (@ob_end_flush());

				exit();
			}
		}
	}

	protected static function getPageCacheId()
	{
		static $sCacheId;

		if (!$sCacheId)
		{
			$parts = array();

			$parts[] = JchOptimizeBrowser::getInstance()->getFontHash();
			$parts[] = JchPlatformUri::getInstance()->toString();

			$sCacheId = md5(serialize($parts));

		}

		return $sCacheId;
	}

	public static function store($sHtml)
	{
		if (self::isCachingEnabled())
		{	
			JchPlatformCache::saveCache($sHtml, self::getPageCacheId());
		}
	}

	public static function isExcluded($params)
	{
		$cache_exclude = $params->get('cache_exclude', array());
		
		if (JchOptimizeHelper::findExcludes($cache_exclude, JchPlatformUri::getInstance()->toString()))
		{
			return true;
		}

		return false;
	}

	public static function isCachingEnabled()
	{

		$params = JchPlatformPlugin::getPluginParams();

		if ($params->get('cache_enable', '0') && JchPlatformUtility::isGuest() && !self::isExcluded($params))
		{
			return true;
		}

		return false;
	}
}

