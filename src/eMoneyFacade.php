<?php

namespace Gabievi\eMoney;

use Illuminate\Support\Facades\Facade;

class eMoneyFacade extends Facade
{

	/**
	 * Get the registered name of the component.
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'eMoney';
	}
}