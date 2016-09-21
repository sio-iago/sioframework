<?php

namespace SIOFramework\Table\Builder;


abstract class TableBuilderAbstract {

	protected $dateFormat;
	
	/**
	 * Creates a new TableBuilder with defined date format
	 * @param String $dateFormat
	 */
	public function __construct($dateFormat = 'Y-m-d h:i:s')
	{
		$this->dateFormat = $dateFormat;
	}
	
}