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
    	$html .= "<th>".$column['label']."</th>";
    }
    $html .= "</tr>";
    
    if (!empty($values)) {
    	print_r($values);
    foreach ($values as $value) {
    $html .= "<tr>";
    
    	foreach ($columns as $column) {
    		$linkkey = (isset($column['linkkey'])) ? $value->{$column['linkkey']} : null;
    		$link = (isset($column['linkbase'])) ? '<a href="' .$column['linkbase'].$linkkey.'">' : null;
    		$endlink = !empty($link) ? "</a>" : null;
    		
    		$html .= "<td>".$link.$value->{$column['name']}.$endlink."</td>";
    	}
    
    $html .= "</tr>";
     
    }
    }
    
    $html .= "</table>";
    return $html;
  }
	
	

  
}