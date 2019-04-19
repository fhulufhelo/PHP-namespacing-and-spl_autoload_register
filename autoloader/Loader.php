<?php

// autoload classes as needed
namespace Autoload;

/**
 * 
 */
class Loader
{
	
	const UNBLE_TO_LOAD = 'Unable to load class';
	// array of directories

	protected static $dirs = array();
	protected static $registered = 0;

	function __construct(array $dirs = null)
	{
		self::init($dirs);
	}

	public function addDris($dirs)
	{
		if (is_array($dirs)) {
			self::$dirs = array_merge(self::$dirs, $dirs);
		} else {
			self::$dirs[] = $dirs;
		}
	}

	/**
	*	Add a directory to the list of the supported directories
	* 	Also registers "autoload" as an autoloading method
	*
	*	@param array | string $dirs
	*/

	public function init($dirs = array())
	{
		if ($dirs) {
			self::addDris($dirs);
		}

		if (self::$registered == 0) {
			spl_autoload_register(__CLASS__ . '::autoload');
			self::$registered++;
		}
	}



	public static function autoload($class)
	{
		$success = FALSE;
		$fn = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

		foreach (self::$dirs as $start) {

			$file = $start . DIRECTORY_SEPARATOR . $fn;

			if (self::LoadFile($file)) {
				$success = TRUE;
				break;
			}
		}

		if (!$success) {
			if (!self::LoadFile(__DIR__ . DIRECTORY_SEPARATOR . $fn)) {
				throw new \Exception(self::UNBLE_TO_LOAD . ' ' .  $class);
				
			}
		}

		return $success;
	}


	protected static function LoadFile($file)

	{
		if (file_exists($file)) {
			require_once $file;
			return true;
		}

		return false;
	}
}