<?php

namespace Anax\Comments;
 
/**
 * Model for Comments.
 *
 */
class Comments extends \Anax\MVC\CDatabaseModel
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

    public function findComment($pagekey=null, $id)
    {
    if (isset($pagekey) && isset($id)) {
		$all = $this->query()
        ->where('pagekey = ?')
        ->andWhere('id = ?')
        ->execute([$pagekey, $id]);
        
        return $all;
	}
    else {	
    	parent::find($id);
    }
    }
    
    /*
    * Save an edited comment
    *
    */
    
     public function editComment($comment, $pagekey, $id)
    {
        $comments = $this->session->get('comments', []);
        $comments[$pagekey][$id] = $comment;
        $this->session->set('comments', $comments);
    }

}