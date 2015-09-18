<?php

namespace Meax\HTMLTable;

class SimpleHTMLTable {


	
	/**
	* Creates an HTML table from an array or object.
	*
	*/
	
	public function __construct() {
	
	  }
	
  
	
	/**
	 * Build an html table
	 *
	 * @param array $columns containing label and corresponding name
	 * @param array $values or @param object $values containing the data
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
    foreach ($values as $value) {
    $html .= "<tr>";
    
    	foreach ($columns as $column) {
    		$link = null;
    		$linkkey = null;
    		$val = '';
    		if (is_object($value)) { 
    			$val = $value->{$column['name']};
    			
    			if (isset($column['linkkey'])) {
    				$linkkey = $value->{$column['linkkey']};
    			}
    		}
    		elseif (is_array($value)) {
    			
    			$val = $value[$column['name']];
    			if (isset($column['linkkey'])) {
    				$linkkey = $value[$column['linkkey']];
    			}
    		}
    		if (isset($column['display'])) {
    		$val = $this->getDisplayVal($val, $column['display']);
    		}
    		
    		$link = (isset($column['linkbase'])) ? '<a href="' .$column['linkbase'].$linkkey.'">' : null;
    		$endlink = !empty($link) ? "</a>" : null;
    		
    		$html .= "<td>".$link.$val.$endlink."</td>";
    		
    	}
    
    $html .= "</tr>";
     
    }
    }
    
    $html .= "</table>";
    return $html;
  }
	
	
  public function getDisplayVal($val, $display=null, $datatype=null) {
  	$displayval = $val;
  	  switch ($display) {
  	  
  	  case 'yes-no':
  	  	  if (empty($val) || $val === false) {
  	  	  	  $displayval = "Nej";
  	  	  }
  	  	  else $displayval = "Ja";
  	  	  
  	  	  break;
  	  }
  	  return $displayval;
  }

  
}