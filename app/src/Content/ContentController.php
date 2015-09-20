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


/**
 * Add new content.
 *
 * 
 *
 * @return void
 */
public function addAction()
{
 
    $form = new \Anax\HTMLForm\CFormContentAdd();
    $form->setDI($this->di);
    $status = $form->check();
    
    $this->di->theme->setTitle("Lägg till innehåll");
    $this->di->views->add('default/page', [
        'title' => "Lägg till innehåll",
        'content' => $form->getHTML(), 
        
        ], 'main');

}

/**
 * Update content.
 *
 * @param $id of content to update.
 *
 * @return void
 */
public function updateAction($id = null)
{

    if (!isset($id)) {
        die("Missing id");
    }
    
    $content = $this->content->find($id);
    $title = $content->getProperties()['title'];
    $url = $content->getProperties()['url'];
    $slug = $content->getProperties()['slug'];
    $data = $content->getProperties()['data'];
    $acronym = $content->getProperties()['acronym'];
    $filter = $content->getProperties()['filter'];
    $type = $content->getProperties()['type'];
    $deleted = $content->getProperties()['deleted'];
    $published = $content->getProperties()['published'];
    
    $form = new \Anax\HTMLForm\CFormContentEdit($id, $title, $url, $slug, $data, $acronym, $filter, $type, $published, $deleted);
    $form->setDI($this->di);
    $status = $form->check();
    
    $this->di->theme->setTitle("Redigera innehåll");
    $this->di->views->add('default/page', [
        'title' => "Redigera innehåll",
        'content' => $form->getHTML()
        ]);

    

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