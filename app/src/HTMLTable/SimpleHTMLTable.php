<?php

namespace Meax\HTMLTable;

class SimpleHTMLTable {


	
	/**
	* 
	*
	*/
	
	public function __construct() {
	
	  }
	
  
	
	/**
	 * Build an html table
	 *
	 * @param array $columns containing label and corresponding name
	 * @param array $values containing the data
	 * 
	 */
	
    public function createTable($columns, $values=null, $tablename=null) {
    	
    $html = "<table id='".$tablename."'>";
    $html .= "<tr>";
    
    foreach ($columns as $column) {
    	$html .= "<th>".$column['label']"</th>";
    }
    $html .= "</tr>";
    
    if (!empty($values)) {
    foreach ($values as $row => $value) {
    $html .= "<tr>";
    
    	foreach ($columns as $column) {
    		$html .= "<td>".$value[$column['name']]."</td>";
    	}
    
    $html .= "</tr>";
     
    }
    }
    
    $html .= "</table>";
    return $html;
  }
	
	

  
}