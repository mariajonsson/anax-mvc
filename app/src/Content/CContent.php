<?php

namespace Meax\Content;
 
/**
 * Model for Comments.
 *
 */
class CContent extends \Anax\MVC\CDatabaseModel
{

	
	public function findAll($pagekey=null)
	{
	
	if (isset($pagekey)) {
		$all = $this->query()
        ->where('pagekey = ?')
        ->execute([$pagekey]);
        
        return $all;
	}
	
	else {
		parent::findAll();
    }
    }

public function getCategories($type="all",$id=null) {

  switch ($type) {
  
  case "all":
  // Get category names
  $sql = "
    SELECT *
    FROM Contentcategories;
    ";
    $res = $this->ExecuteSelectQueryAndFetchAll($sql);
    return $res;
    break;
    
    case "perpost":
    if (isset($id)) {
    //Get categories for a post id
    $sql = "
    SELECT catname, catid
    FROM VCategories
      WHERE id = ?;
    ";
    $params = array($id);
    $res = $this->ExecuteSelectQueryAndFetchAll($sql,$params);
    
    return $res;
    }
    
    break;
    
    }
    

}



  public function setParameters() {
  
    $this->id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
    $this->title  = isset($_POST['title']) ? $_POST['title'] : null;
    $this->slug   = isset($_POST['slug'])  ? $_POST['slug']  : null;
    $this->url    = isset($_POST['url'])   ? strip_tags($_POST['url']) : null;
    $this->data   = isset($_POST['data'])  ? $_POST['data'] : array();
    $this->type   = isset($_POST['type'])  ? strip_tags($_POST['type']) : array();
    $this->filter = isset($_POST['filter']) ? $_POST['filter'] : array();
    $this->published = isset($_POST['published'])  ? strip_tags($_POST['published']) : array();
    $this->ispublished = isset($_POST['ispublished'])  ? strip_tags($_POST['ispublished']) : array();
    $this->save   = isset($_POST['save'])  ? true : false;
    $this->delete   = isset($_POST['delete'])  ? $_POST['delete'] : null;
    $this->action = isset($_POST['save'])  ? $_POST['save'] : null;
    $this->acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
    $this->author = isset($_SESSION['user']) ? $_SESSION['user']->name : null;
    $this->authorid = isset($_SESSION['user']) ? $_SESSION['user']->id : null;
    $this->restore   = isset($_POST['restore'])  ? true : false;
    $this->categories = isset($_POST['categories']) ? $_POST['categories'] : null ;
    $this->allcategories = $this->getCategories();
    $this->loggedin = isset($_SESSION['user']) ? true : false;
    

  
  }


}