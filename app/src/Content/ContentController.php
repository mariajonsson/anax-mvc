<?php
namespace Meax\Content;
 
/**
 * A controller for content and admin related events.
 *
 */
class ContentController extends ContentBasicController 
{
    
    private $columns;
 
/**
 * Initialize the controller.
 *
 * @return void
 */
public function initialize()
{
    $this->content = new \Meax\Content\Content();
    $this->content->setDI($this->di);
}


/**
 * List content as html table based on selected columns
 *
 * @return void
 */
public function listColumnsTableAction()
{
	$this->setColumns();
	
	$columnlist = '';
	if (!empty($this->columns)) {
		foreach ($this->columns as $column) {
		 $columnlist .= $column['name'].', ';
		}
		$columnlist = trim($columnlist, ', ');
	}
	else $columnslist = '*';
	
	$all = $this->content
	    ->query($columnlist)
	    ->execute();
	
	$table = new \Meax\HTMLTable\SimpleHTMLTable;
	$contenttable = $table->createTable($this->columns, $all);
	
	$this->theme->setTitle("Innehåll");
    $this->views->add('default/page', [
        'content' => $contenttable,
        'title' => "Allt innehåll",
    ], 'main');
	
}




  public function setColumns() 
  {

	$this->columns = array([
      'name' => 'id',
      'label' => 'ID',
    ],
    [
      'name' => 'title',
      'label' => 'Rubrik',
      'linkbase' => 'id/',
      'linkkey' => 'id',
    ],
    [
      'name' => 'acronym',
      'label' => 'Av',
      ],
    [
      'name' => 'published',
      'label' => 'Publicerad',
      'display' => 'yes-no',
    ],
    [
      'name' => 'created',
      'label' => 'Skapad',
      'display' => 'convert-datestr',
      'displayformat' => 'Y-m-d H:i',
    ],
    [
      'name' => 'type',
      'label' => 'Typ',
    ]
    );
  }



}