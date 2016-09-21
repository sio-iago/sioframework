<?php

namespace SIOFramework\Table\Builder;

use SIOFramework\Table\TableInterface;

class ModelTableBuilder extends TableBuilder{
	
	/**
	 * Creates a ready TableInterface using an implementation
	 * provided in $tableFullName
	 * 
	 * @param string $tableFullName the class full name [namespace\class]
	 * @param array $headers
	 * @param array $model_objects
	 * @param string $title
	 * @param string $id
	 * @param string $css_class
	 * @throws BuilderException
	 * 
	 * @return TableInterface
	 */
	public function buildTable($tableFullName, $headers=[],$model_params=[],$model_objects=[],$title="",$id="",$css_class="")
	{
		$table = parent::buildTable($tableFullName,$headers,[],$title,$id,$css_class);
		
		$tableRows = [];
		
		foreach($model_objects as $obj)
		{
			$row = [];
			
			foreach($model_params as $col)
			{
				// See if it's a simple param or an object chain
				$getters = explode('.', $col);
				
				$param = NULL;
				
				// String param
				if(count($getters)==1)
				{
					$getter = 'get'.ucfirst($col);
					$param = $obj->$getter();
				}
				// Object chain. Ex: order.user.id
				else
				{
					// Last object in the chain
					$lastObject = $obj;
					
					// Goes throught the object chain
					foreach($getters as $val)
					{
						$getter = 'get'.ucfirst($val);
						$lastObject = $lastObject->$getter();
					}
					
					$param = $lastObject;
				}
				
				if($param instanceof \DateTime)
					$row[] = $param->format($this->dateFormat);
				else if(!is_object($param))
					$row[] = $param;
				else
					$row[] = 'error';
			}
			
			$tableRows[] = $row;
		}
		
		$table->setTableData($tableRows);
		
		return $table;
	}
	
}