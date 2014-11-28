<?php namespace SOSTheBlack\Moip;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * Facade
 * 
 * @author Jean Cesar Garcia <jeancesargarcia@gmail.com>
 * @version v1.*
 * @license <a href="http://www.opensource.org/licenses/bsd-license.php">BSD License</a>
 */
class Facade extends BaseFacade
{
	/**
	 * getFacadeAccessor()
	 * 
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'moip';
	}
}