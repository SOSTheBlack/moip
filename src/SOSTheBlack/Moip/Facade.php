<?php namespace SOSTheBlack\Moip;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * Facade
 * 
 * @author Jean Cesar Garcia <jeancesargarcia@gmail.com>
 * @version v1.0.0
 * @license <a href="http://www.opensource.org/licenses/bsd-license.php">BSD License</a>
 */
class Facade extends BaseFacade
{
	protected static function getFacadeAccessor()
	{
		return 'moip';
	}
}