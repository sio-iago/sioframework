<?php

namespace SIOFramework\Table;

class StandardTable implements TableInterface {
	
	
	/**
	 * Table title
	 * @var string
	 */
	protected $title;
	
	/**
	 * Html Class
	 * @var string
	 */
	protected $cssClass = '';
	
	/**
	 * Html id
	 * @var string
	 */
	protected $id = '';
	
	
	/**
	 * Table headers.
	 * @var array
	 */
	protected $headers = [];
	
	/**
	 * Table data.
	 * @var array
	 */
	protected $bodyData = [];
	
	/**
	 * {@inheritDoc}
	 * @see \SIOFramework\Table\TableInterface::setTableTile()
	 */
	public function setTableTile($title) {
		$this->title = $title;
	}

	/**
	 * {@inheritDoc}
	 * @see \SIOFramework\Table\TableInterface::setTableHeader()
	 */
	public function setTableHeader(array $data) {
		$this->headers = $data;
	}

	/**
	 * {@inheritDoc}
	 * @see \SIOFramework\Table\TableInterface::setTableData()
	 */
	public function setTableData(array $data) {
		$this->bodyData = $data;
	}

	/**
	 * {@inheritDoc}
	 * @see \SIOFramework\Table\TableInterface::setTableId()
	 */
	public function setTableId($id) {
		$this->id = $id;
	}

	/**
	 * {@inheritDoc}
	 * @see \SIOFramework\Table\TableInterface::setTableClass()
	 */
	public function setTableClass($css_class) {
		$this->cssClass = $css_class;
	}

	/**
	 * {@inheritDoc}
	 * @see \SIOFramework\Table\TableInterface::beginTable()
	 */
	public function beginTable() {
		return '<table class="'.$this->cssClass.'" id="'.$this->id.'">';
	}

	/**
	 * {@inheritDoc}
	 * @see \SIOFramework\Table\TableInterface::renderTableHeader()
	 */
	public function renderTableHeader() {
		$tHead = '<thead><tr>';
		
		foreach ($this->headers as $header)
		{
			$tHead .= '<th>'.$header.'</th>';
		}
		
		$tHead .= '</tr></thead>';
		
		return $tHead;
	}

	/**
	 * {@inheritDoc}
	 * @see \SIOFramework\Table\TableInterface::renderTableBody()
	 */
	public function renderTableBody() {
		$tBody = '<tbody>';
		
		foreach($this->bodyData as $rowColumns)
		{
			$tBody .= '<tr>';
			
			foreach($rowColumns as $col)
			{
				$tBody .= '<td>'.$col.'</td>';
			}
			
			$tBody .= '</tr>';
		}
		
		$tBody .= '</tbody>';
		
		return $tBody;
	}

	/**
	 * {@inheritDoc}
	 * @see \SIOFramework\Table\TableInterface::endTable()
	 */
	public function endTable() {
		return '</table>';
	}
	
	/**
	 * {@inheritDoc}
	 * @see \SIOFramework\Table\TableInterface::renderTable() 
	 */
	public function renderTable()
	{
		$table = $this->beginTable();
		$table .= $this->renderTableHeader();
		$table .= $this->renderTableBody();
		$table .= $this->endTable();
		
		return $table;
	}

}