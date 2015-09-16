<?php

namespace Meax\HTMLTable;

class HTMLTable {

	private $columns;
	
	/**
	* @param array $columns - array with columns
	*
	*/
	
	public function __construct($columns) {
  }
  
  
  /**
	 * Use the current querystring as base, modify it according to $options and return the modified query string.
	 *
	 * @param array $options to set/change.
	 * @param string $prepend this to the resulting query string
	 * @return string with an updated query string.
	 */
	function getQueryString($options, $prepend='?') {
	  // parse query string into array
	  $query = array();
	  parse_str($_SERVER['QUERY_STRING'], $query);
	 
	  // Modify the existing query string with new options
	  $query = array_merge($query, $options);
	 
	  // Return the modified querystring
	  return $prepend . http_build_query($query);
	}
	
	
    public function showTable($columns, $values) {
    	
    $orderby = ($column['sortable']==true) ? $this->orderby(column['name']) : null;

    $html = "<table>";
    $html .= "<tr>";
    
    foreach ($columns as $column) {
    	$html .= "<td>".$column['label'].$orderby."</td>";
    }
    $html .= "</tr>";
    
    foreach ($values as $row => $value) {
    
      $html .= "<tr><td>$row</td><td>{$film->id}</td><td><img src='{$film->image}'></td><td>{$film->title}</td><td>{$film->director}</td><td>{$film->YEAR}</td><td>{$film->genre}</td></tr>";
    
    }
    
    $html .= "</table>";
    return $html;
  }
	
	
  /**
  * Function to create links for sorting
  *
  * @param string $column the name of the database column to sort by
  * @return string with links to order by column.
  */
  public function orderby($column) {
    return "<span class='orderby'><a href='?{$this->query}orderby={$column}&order=asc'>&darr;</i></a><a href='?{$this->query}orderby={$column}&order=desc'>&uarr;</a></span>";
  }
  
	  /**
	 * Create links for hits per page.
	 *
	 * @param array $hits a list of hits-options to display.
	 * @return string as a link to this page.
	 */
	function getHitsPerPage($hits) {
	  $nav = "Träffar per sida: ";
	  foreach($hits AS $val) {
		$nav .= "<a href='" . $this->getQueryString(array('hits' => $val)) . "'>$val</a> ";
	  }  
	  return $nav;
	}
  
  
}