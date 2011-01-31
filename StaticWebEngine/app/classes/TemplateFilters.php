<?php
/**
 * Static Web.
 *
 * @copyright    Copyright (c) 2010 Jan Tvrdík
 * @license      MIT
 * @package      StaticWeb
 */

namespace StaticWeb;

use Nette;
use Nette\Debug;



/**
 * Custom template filters.
 *
 * @author   Jan Tvrdík
 */
class TemplateFilters
{
	/** @var \Texy */
	public static $texy;



	/**
	 * Processes <texy>...</texy> elements.
	 *
	 * @author   David Grudl, Jan Tvrdík
	 * @param    string
	 * @return   string
	 */
	public static function texyElements($s)
	{
		$texy = self::$texy;
		if ($texy === NULL) throw new \InvalidStateException(get_class($this) . '::$texy must be set.');

		return Nette\String::replace($s, '#<texy>(.*?)</texy>#s', function ($m) use ($texy) {
				$s = $m[1];
				$singleLine = (strpos($s, "\n") === FALSE);
				$s = trim($s, "\n");
				$tabs = strspn($s, "\t");
				if ($tabs) $s = Nette\String::replace($s, "#^\t{1,$tabs}#m", '');
				$s = $texy->process($s, $singleLine);
				return "{syntax double}$s{{/syntax}}";
			}
		);
	}

}
