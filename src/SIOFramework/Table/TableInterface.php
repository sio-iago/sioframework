<?php

namespace SIOFramework\Table;

/**
 * Interface to Implement table helpers.
 * @author silvaio
 */
interface TableInterface {
	
	// Setters
	
	/**
	 * Sets the table title.
	 * @param string $title
	 */
	public function setTableTile($title);
	
	/**
	 * Sets the header columns
	 * @param array $data
	 */
	public function setTableHeader(array $data);
	
	/**
	 * Sets the body data
	 * @param array[row][column] $data
	 */
	public function setTableData(array $data);
	
	
	/**
	 * Sets the table html id.
	 * @param string $id
	 */
	public function setTableId($id);
	
	/**
	 * Sets the table html clas(ses)
	 * @param string $css_class
	 */
	public function setTableClass($css_class);
	
	
	// Rendering methods
	
	/**
	 * Begins the table rendering.
	 */
	public function beginTable();
	
	/**
	 * Renders the headers
	 */
	public function renderTableHeader();
	
	/**
	 * Renders the body
	 */
	public function renderTableBody();
	
	/**
	 * Ends the table rendering.
	 */
	public function endTable();
	
	/**
	 * Renders the full table
	 */
	public function renderTable();
}