<?php

namespace SIOFramework\Table\Builder;

use SIOFramework\Table\TableInterface;

class TableBuilder extends TableBuilderAbstract {
	
	/**
	 * Creates a ready TableInterface using an implementation
	 * provided in $tableFullName
	 * 
	 * @param string $tableFullName the class full name [namespace\class]
	 * @param array $headers
	 * @param array $data
	 * @param string $title
	 * @param string $id
	 * @param string $css_class
	 * @throws BuilderException
	 * 
	 * @return TableInterface
	 */
	public function buildTable($tableFullName, $headers=[],$data=[],$title="",$id="",$css_class="")
	{
		$table = new $tableFullName();
		
		if(!($table instanceof TableInterface))
			throw new BuilderException('Invalid table instance');
		
		$table->setTableTile($title);
		$table->setTableId($id);
		$table->setTableClass($css_class);
		
		$table->setTableHeader($headers);
		$table->setTableData($data);
		
		return $table;
	}
	
}