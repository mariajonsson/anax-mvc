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
    		
    		$link = (isset($value[$column['link']])) ? '<a href="' .$value[$column['link']].'">' : null;
    		$endlink = !empty($link) ? "</a>" : null;
    		
    		$html .= "<td>".$link.$value[$column['name']].$endlink."</td>";
    	}
    
    $html .= "</tr>";
     
    }
    }
    
    $html .= "</table>";
    return $html;
  }
	
	

  
}