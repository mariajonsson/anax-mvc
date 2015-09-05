<?php
namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
 
/**
 * Initialize the controller.
 *
 * @return void
 */
public function initialize()
{
    $this->users = new \Anax\Users\User();
    $this->users->setDI($this->di);
}

/**
 * List all users.
 *
 * @return void
 */
public function listAction()
{
 
    $all = $this->users->findAll();
    
    $addurl = $this->di->get('url')->create('users/add');
    $deleteurl = $this->di->get('url')->create('users/discarded');
    $activeurl = $this->di->get('url')->create('users/active');
    $inactiveurl = $this->di->get('url')->create('users/inactive');
 
    $this->theme->setTitle("Användare");
    $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Alla användare",
    ], 'main');
    $this->views->add('default/page', [
        'title' => " ",
        'content' => "<h4>Administration</h4> ",
        'links' => array(
		    ['text' => '<i class="fa fa-user-plus fa-fw"></i> Lägg till 
användare', 'href' => $addurl], 
		    ['text' => '<i class="fa fa-user-times fa-fw 
user-deleted"></i> Administrera borttagna användare', 'href' => $deleteurl],
		    ['text' => '<i class="fa fa-user fa-fw"></i> Se aktiva 
användare', 'href' => $activeurl],
		    ['text' => '<i class="fa fa-user fa-fw user-inactive"></i> 
Se inaktiva användare', 'href' => $inactiveurl],
		    )
    ], 'sidebar');
}

/**
 * List user with id.
 *
 * @param int $id of user to display
 *
 * @return void
 */
public function idAction($id = null)
{
    $user = $this->users->find($id);
 
    $this->theme->setTitle("Användare");
    $this->views->add('users/view', [
        'user' => $user,
    ]);
}

/**
 * Add new user.
 *
 * @param string $acronym of user to add.
 *
 * @return void
 */
public function addAction($acronym = null)
{

    
    $form = new \Anax\HTMLForm\CFormUserAdd();
    $form->setDI($this->di);
    $status = $form->check();
    
  
    $this->di->theme->setTitle("Lägg till användare");
    $this->di->views->add('default/page', [
        'title' => "Lägg till användare",
        'content' => $form->getHTML()
        ]);
    

}

/**
 * Update user.
 *
 * @param $id of user to update.
 *
 * @return void
 */
public function updateAction($id = null)
{

    if (!isset($id)) {
        die("Missing id");
    }
    
    $user = $this->users->find($id);
    $name = $user->getProperties()['name'];
    $acronym = $user->getProperties()['acronym'];
    $email = $user->getProperties()['email'];
    $active = $user->getProperties()['active'];
    $deleted = $user->getProperties()['deleted'];
    $created = $user->getProperties()['created'];
    
    $form = new \Anax\HTMLForm\CFormUserUpdate($id, $acronym, $name, $email, $active, $created);
    $form->setDI($this->di);
    $status = $form->check();
    
  
    $this->di->theme->setTitle("Redigera användare");
    $this->di->views->add('default/page', [
        'title' => "Redigera användare",
        'content' => "<h4>".$user->getProperties()['acronym']." 
(id ".$user->getProperties()['id'].")</h4>".$form->getHTML()
        ]);
    

}


public function insertUser($acronym)
{
    $now = gmdate('Y-m-d H:i:s');

    $this->users->save([
        'acronym' => $acronym,
        'email' => $acronym . '@mail.se',
        'name' => 'Mr/Mrs ' . $acronym,
        'password' => password_hash($acronym, PASSWORD_DEFAULT),
        'created' => $now,
        'active' => $now,
    ]);

}

/**
 * Delete user.
 *
 * @param integer $id of user to delete.
 *
 * @return void
 */
public function deleteAction($id = null)
{
    if (!isset($id)) {
        die("Missing id");
    }
 
    $res = $this->users->delete($id);
 
    $url = $this->url->create('users');
    $this->response->redirect($url);
}


/**
 * Delete (soft) user.
 *
 * @param integer $id of user to delete.
 *
 * @return void
 */
public function activateAction($id = null,$route1=null,$route2=null)
{
    if (!isset($id)) {
        die("Missing id");
    }
    

    
    $route2 = isset($route2) ? "/".$route2:null;
 
    $now = gmdate('Y-m-d H:i:s');
 
    $user = $this->users->find($id);
    
    if ($user->deleted != null) {
      $user->deleted = null;
    }
    elseif ($user->active == null) { 
      $user->active = $now;
    }
    else {
      $user->active = null;
    }
    $user->save();
 
    $url = $this->url->create($route1.$route2);
    $this->response->redirect($url);
}


/**
 * Delete (soft) user.
 *
 * @param integer $id of user to delete.
 *
 * @return void
 */
public function softDeleteAction($id = null)
{
    if (!isset($id)) {
        die("Missing id");
    }
 
    $now = gmdate('Y-m-d H:i:s');
 
    $user = $this->users->find($id);
 
    $user->deleted = $now;
    $user->save();
 
    $url = $this->url->create('users/id/' . $id);
    $this->response->redirect($url);
}

/**
 * List all active and not deleted users.
 *
 * @return void
 */
public function activeAction()
{
    $all = $this->users->query()
        ->where('active IS NOT NULL')
        ->andWhere('deleted is NULL')
        ->execute();
 
    $this->theme->setTitle("Aktiva användare");
    $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Aktiva användare",
    ], 'main');

}


public function inactiveAction()
{
    $all = $this->users->query()
        ->where('active IS NULL')
        ->andWhere('deleted is NULL')
        ->execute();
 
    $this->theme->setTitle("Inaktiva användare");
    $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Inaktiva användare",
    ]);
}

public function discardedAction()
{
    $all = $this->users->query()
        ->where('deleted is NOT NULL')
        ->execute();
 
    $this->theme->setTitle("Papperskorgen");
    $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Papperskorgen",
    ]);
}
}