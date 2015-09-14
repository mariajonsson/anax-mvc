<?php
namespace Meax\Content;
 
/**
 * A controller for users and admin related events.
 *
 */
class CContentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
 
/**
 * Initialize the controller.
 *
 * @return void
 */
public function initialize()
{
    $this->content = new \Meax\Content\CContent();
    $this->content->setDI($this->di);
}

/**
 * List all users.
 *
 * @return void
 */
public function listAction()
{
 
    $all = $this->users->findAll();
    
    $this->theme->setTitle("Användare");
    $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Alla användare",
    ], 'main');
    $this->views->add('users/adminmenu', [], 'sidebar');
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
    $post = $this->content->find($id);
 
    $this->theme->setTitle("Innehåll");
    $this->views->add('users/view', [
        'user' => $post,
    ], 'main');
    //$this->views->add('users/adminmenu', [], 'sidebar');
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
    
    //$info = $this->di->fileContent->get('users-addinfo.md');
    //$info = $this->di->textFilter->doFilter($info, 'shortcode, markdown');
  
    $this->di->theme->setTitle("Lägg till innehåll");
    $this->di->views->add('default/page', [
        'title' => "Lägg till användare",
        'content' => $form->getHTML(), 
        
        ], 'main');

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
    
    $info = $this->di->fileContent->get('users-editinfo.md');
    $info = $this->di->textFilter->doFilter($info, 'shortcode, markdown');
    
    $this->di->theme->setTitle("Redigera användare");
    $this->di->views->add('default/page', [
        'title' => "Redigera användare",
        'content' => "<h4>".$user->getProperties()['acronym']." 
(id ".$user->getProperties()['id'].")</h4>".$form->getHTML()
        ]);
    $this->views->add('theme/info', [
	'content' => $info,
	'class'   => 'user-instructions',
	'links'   => array(
		      ['text' => 'Till huvudmeny', 
		       'href' => $this->url->create('users')]),
      ], 'sidebar');
    

}


public function insertUserAction($acronym, $email=null, $name=null)
{

    if (!isset($acronym)) {
        die("Missing acronym");
    }
    $now = gmdate('Y-m-d H:i:s');

    $this->users->save([
        'acronym' => $acronym,
        'email' => $email,
        'name' => $acronym,
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
    
    $route1 = isset($route1) ? $route1:'users';
    
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
    $this->views->add('users/adminmenu', [], 'sidebar');

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
    ], 'main');
    $this->views->add('users/adminmenu', [], 'sidebar');
}

public function discardedAction()
{
    $all = $this->users->query()
        ->where('deleted is NOT NULL')
        ->execute();
 
    $this->theme->setTitle("Papperskorgen");
    $this->views->add('users/list-deleted', [
        'users' => $all,
        'title' => "Papperskorgen",
    ], 'main');
    $this->views->add('users/adminmenu', [], 'sidebar');
}

public function resetUsersAction()
{

    //$this->db->setVerbose();
 
    $this->db->dropTableIfExists('user')->execute();
 
    $this->db->createTable(
        'user',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
        ]
    )->execute();
    
    $this->db->insert(
        'user',
        ['acronym', 'email', 'name', 'password', 'created', 'active']
    );
 
    $now = date('Y-m-d H:i:s');
 
    $this->db->execute([
        'admin',
        'admin@dbwebb.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
 
    $this->db->execute([
        'doe',
        'doe@dbwebb.se',
        'John/Jane Doe',
        password_hash('doe', PASSWORD_DEFAULT),
        $now,
        $now
     ]);
     
         $this->db->execute([
        'maria',
        'choklad@post.utfors.se',
        'Maria',
        password_hash('maria', PASSWORD_DEFAULT),
        $now,
        null
     ]);
     
     $this->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'list',
        //'params'     => [],
    ]);
    
    
}

    public function createContent() {
  
      // Check that incoming parameters are valid
    //isset($this->acronym) or die('Check: Logga in.');
        
    $select =  "<select multiple name='categories[]'>";
    
      foreach ($this->allcategories as $cat) {
	$select .= "<option value=". $cat->catid . " >". $cat->catname . "</option>";
       }
    $select .= "</select>";
  
 
  $html = <<<EOD
  <form method=post>
  <fieldset>
  <legend>Lägg till innehåll</legend>
  <input type='hidden' name='id' value=''/>
  <input type='hidden' name='author' value='{$this->acronym}'/>
  <p><label>Titel:<br/><input type='text' name='title' value='' required /></label></p>
  <p><label>Slug:<br/><input type='text' name='slug' value=''/></label></p>
  <p><label>Url:<br/><input type='text' name='url' value=''/></label></p>
  <p><label>Text:<br/><textarea rows=9 cols=60 name='data'></textarea></label></p>
  <p><label>Type:<br/><span class='discreet'>post eller page</span><br/><input type='text' name='type' value=''/></label></p>
  <p><label>Filter:<br/><span class='discreet'>Tillgängliga filter: link, markdown, bbcode, nl2br</span><br/><input type='text' name='filter' value='' required/></label></p>
  <p><label>Kategorier:</label><br/>{$select}</p>
  <p><label>Publicera nu: <input type='checkbox' name='ispublished' value='Ja'/></label></p>
  <p class=buttons><input type='submit' name='save' value='Skapa'/> <input type='reset' value='Återställ'/></p>
  
  <output>{$this->output}</output>
  </fieldset>
  </form>
EOD;
  
  return $html;
  
  }
  
    public function editContent() {

      // Check that incoming parameters are valid
    isset($this->acronym) or die('Check: Logga in .');
    is_numeric($this->id) or die('Check: Id ska vara numeriskt.');
    
    $postcats = $this->getCategories("perpost", $this->id); 
    
    $select =  "<select multiple name='categories[]'>";
    $selected = null;
      foreach ($this->allcategories as $cat) {
	foreach ($postcats as $postcat) {
	  if ($selected == null) {
	  if ($postcat->catid  == $cat->catid) {$selected = "selected";}
	  }}
      $select .= "<option value=". $cat->catid . " {$selected}>". $cat->catname . "</option>";
      $selected = null;
      }
    $select .= "</select>";
    
    $publish = ($this->published == null) ? "<label>Innehållet är ej publicerat. Publicera: <input type='checkbox' name='ispublished' value='Ja'/></label>" : "<label><span class='discreet'>Innehållet publicerades {$this->published}. </span><br/>Avpublicera: <input type='checkbox' name='ispublished' value='Nej'/></label>" ;
  
 
  $html = <<<EOD
  <form method=post>
  <fieldset>
  <legend>Uppdatera innehåll</legend>
  <input type='hidden' name='id' value='{$this->id}'/>
  <input type='hidden' name='published' value='{$this->published}'/>
  <p><label>Titel:<br/><input type='text' name='title' value='{$this->title}'/></label></p>
  <p><label>Slug:<br/><input type='text' name='slug' value='{$this->slug}'/></label></p>
  <p><label>Url:<br/><input type='text' name='url' value='{$this->url}'/></label></p>
  <p><label>Text:<br/><textarea rows=9 cols=60 name='data'>{$this->data}</textarea></label></p>
  <p><label>Type:<br/><span class='discreet'>post eller page</span><br/><input type='text' name='type' value='{$this->type}'/></label></p>
  <p><label>Filter:<br/><span class='discreet'>Tillgängliga filter: link, markdown, bbcode, nl2br</span><br/><input type='text' name='filter' value='{$this->filter}' required/></label></p>
  <p><label>Kategorier:</label><br/>{$select}</p>
  <p>{$publish}</p>
  <p class=buttons><input type='submit' name='save' value='Spara'/> <input type='reset' value='Återställ'/></p>
  <p><a href='view.php'>Visa alla</a></p>
  <output>{$this->output}</output>
  </fieldset>
  </form>
EOD;
  
  return $html;
  
  }
  
  
  /**
  * This method will retreive all posts
  *
  *
  *
  **/
  
   public function getAction() {
    
  
    // Get all content
    
    $all = $this->content->findAll();
    
    $this->theme->setTitle("Innehåll");
    $this->views->add('content/list-all', [
        'content' => $all,
        'title' => "Allt innehåll",
    ], 'main');
    //$this->views->add('users/adminmenu', [], 'sidebar');
    
    $sql = '
    SELECT TYPE, title, Content.id AS id, name, slug, url, deleted, (published <= NOW()) AS available
    FROM Content, USER where Content.user = USER.id;
    ';
    $res = $this->ExecuteSelectQueryAndFetchAll($sql);
    
    
    
     else {
      die('Misslyckades lista sidorna');
    }

    
    
    ////////////
    /*
    case "edit":

    // Select from database
    $sql = 'SELECT * FROM Content WHERE id = ?';
    $res = $this->ExecuteSelectQueryAndFetchAll($sql, array($this->id));

    if(isset($res[0])) {
      $c = $res[0];
    }
    else {
      die('Misslyckades: inget id hittades.');
      
    }
    
    
    // Sanitize content before using it.
    $this->title  = htmlentities($c->title, null, 'UTF-8');
    $this->slug   = htmlentities($c->slug, null, 'UTF-8');
    $this->url    = htmlentities($c->url, null, 'UTF-8');
    $this->data   = htmlentities($c->DATA, null, 'UTF-8');
    $this->type   = htmlentities($c->TYPE, null, 'UTF-8');
    $this->filter = htmlentities($c->FILTER, null, 'UTF-8');
    $this->published = htmlentities($c->published, null, 'UTF-8');
    
    return $this->editContent();
    
    break;
    
    case "page":
    
    // Get parameters 
    $this->url     = isset($_GET['url']) ? $_GET['url'] : null;
    $this->acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
    
          // Get content
    $sql = "
    SELECT *
    FROM Content
    WHERE
      type = 'page' AND
      url = ? AND
      published <= NOW();
    ";
    $res = parent::ExecuteSelectQueryAndFetchAll($sql, array($this->url));
    
    if(isset($res[0])) {
      $c = $res[0];
    }
    else {
      die('Misslyckades');
    }
    
    
    // Sanitize content before using it.
    $this->title  = htmlentities($c->title, null, 'UTF-8');
    $this->data   = $this->doFilter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);
    
    break;
    
    case "blog":
    
    // Get parameters 
    $this->slug    = isset($_GET['slug']) ? $_GET['slug'] : null;
    $this->acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
    
    // Get content
    $slugSql = $this->slug ? 'slug = ?' : '1';
    $sql = "
    SELECT title, DATA, Content.id AS id, USER.id AS userid, FILTER, published, updated, created, name, slug, url
    FROM Content, USER
    WHERE
      (Content.user = USER.id) AND 
      type = 'post' AND
      $slugSql AND
      published <= NOW()
    ORDER BY published DESC, updated DESC
    ;
    ";
    $res = $this->ExecuteSelectQueryAndFetchAll($sql, array($this->slug));
    
    
   
    if(isset($res[0])) {
      $html = "";
      foreach($res as $c) {
	$categories = $this->getCategories("perpost", $c->id);
	$title  = htmlentities($c->title, null, 'UTF-8');
	$data   = $this->doFilter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);
	$pubdate = htmlentities($c->published, null, 'UTF-8');
	$createdate= htmlentities($c->created, null, 'UTF-8');
	$update = (isset($c->updated)) ? htmlentities($c->updated, null, 'UTF-8'):null;
	$author = htmlentities($c->name, null, 'UTF-8');

	$html .= "<section>";
	$html .=  "<article>";
	$html .=  "<header>";
	$html .=  "  <h1><a href='blog.php?slug={$c->slug}'>{$title}</a></h1>";
	$html .=  "  </header>";
	$html .=  $data;
	if (isset($categories[0])) {
	  $html .= "<p class='contentcategories'>Kategorier: <span class='contentcategories'>";
	  foreach($categories as $category){ 
	  $html .= " " . htmlentities($category->catname, null, 'UTF-8') . " ";
	 }
	$html .= "</span></p>";
	}
	$html .= "<p class='discreet'>Skapad av " . $author . " ". $createdate . ". "; 
	$html .= "<br/>Publicerad: " . $pubdate . ". ";
	$html .= isset($update) ? "Uppdaterad: " . $update ."." : "";
	$html .= "</p>";
	$html .=  " </article>";
	$html .=  "</section>";

      }
    }
    else if($this->slug) {
      $anax['main'] = "Det fanns inte en sådan bloggpost.";
    }
    else {
      $html .= "Det fanns inga bloggposter.";
    }
    return $html;
    break;
    
    
    case "delete":
    
    $this->deleteContent();
    // Get all content
    $sql = '
    SELECT *, (published <= NOW()) AS available
    FROM Content;
    ';
    $res = $this->ExecuteSelectQueryAndFetchAll($sql);
    
    // Put results into a list
    if(isset($res[0])) {
      $items = null;
      $items .= "<output>{$this->output}</output>";
      $items .= "<h2>Innehåll</h2>";
      foreach($res AS $key => $val) {
      if (!isset($val->deleted)) {
      $items .= "<form method='post' action='?'><label>{$val->TYPE} (" . (!$val->available ? 'inte ' : null) . "publicerad): " . htmlentities($val->title, null, 'UTF-8') . " </label><input type='hidden' name='id' value='{$val->id}'><input type='submit' name='delete' value='Ta bort'></form><br/>\n";
      }
      }
      $items .= "<h2>Papperskorgen</h2>";
      foreach($res AS $key => $val) {
      if (isset($val->deleted)) {
      $items .= "<form method='post' action='?'><label>{$val->TYPE} (" . (!$val->available ? 'inte ' : null) . "publicerad): " . htmlentities($val->title, null, 'UTF-8') . " </label><input type='hidden' name='id' value='{$val->id}'><input type='submit' name='delete' value='Radera'></form><br/>\n";
      }
      }
      return $items;
    }
    
     else {
      die('Misslyckades med radering.');
    }
    break;
      
    }
 */
  } 
   public function saveContent() {
  // Check if form was submitted
    $this->output = null;
    if($this->save) {
     
     if ($this->ispublished == "Ja") {
	$this->published = date('Y-m-d H:i:s');
      }
      elseif ($this->ispublished == "Nej") {
	$this->published = null;

      }

    
    switch ($this->action) {
    
    case "Spara":
    
      $sql = '
	UPDATE Content SET
	  title   = ?,
	  slug    = ?,
	  url     = ?,
	  DATA    = ?,
	  TYPE    = ?,
	  FILTER  = ?,
	  published = ?,
	  updated = NOW()
	WHERE 
	  id = ?
      ';
        
      
      
      $this->url = empty($this->url) ? null : $this->url;
      $params = array($this->title, $this->slug, $this->url, $this->data, $this->type, $this->filter, $this->published, $this->id);
      $res = $this->ExecuteQuery($sql, $params);
      if($res) {
	$this->output = 'Informationen sparades. ';
      }
      else {
	$this->output = 'Informationen sparades EJ.<br><pre>' . print_r(parent::ErrorInfo(), 1) . '</pre>';
      }
      
      if (isset($this->categories)) {
      //Categories
      $sql = 'DELETE FROM Content2Cat WHERE contentid = ?';
      $params = array($this->id);
      $res = $this->ExecuteQuery($sql, $params);
       if($res) {
	$this->output .= 'Gamla kategorier togs bort. ';
      }
      else {
	$this->output .= 'Kategorier togs EJ bort.<br><pre>' . print_r(parent::ErrorInfo(), 1) . '</pre>';
      }
      
      
      foreach ($this->categories as $cat) {
	
	$sql = 'INSERT INTO Content2Cat (contentid,catid) VALUES (?,?)';
	$params = array($this->id,$cat);
	$res = $this->ExecuteQuery($sql, $params);
	if($res) {
	$this->output .= 'Nya kategorier sparades. ';
	}
	else {
	$this->output .= 'Kategorier sparades EJ.<br><pre>' . print_r(parent::ErrorInfo(), 1) . '</pre>';
	}
      }
      }
      
      break;
      
      case "Skapa":
      $this->slug = ($this->slug == null)? slugify($this->title) : $this->slug ;
      $this->url = ($this->url == null)? slugify($this->title) : $this->url ;
     if ($this->ispublished == "Ja") {
	$this->published = date('Y-m-d H:i:s');
      }
      elseif (!isset($this->ispublished)) {
	$this->published = null;

      }

      
      $sql = 'INSERT INTO Content (title, slug, url, DATA, TYPE, FILTER, user, published, created) VALUES (?,?,?,?,?,?,?,?,NOW())';
      $this->ExecuteQuery($sql, array($this->title, $this->slug, $this->url, $this->data, $this->type, $this->filter, $this->authorid, $this->published));
      $this->SaveDebug();
      $this->id = $this->LastInsertId();
      
      if (isset($this->categories)) {
      //Categories
      foreach ($this->categories as $cat) {
	
	$sql = 'INSERT INTO Content2Cat (contentid,catid) VALUES (?,?)';
	$params = array($this->id,$cat);
	$res = $this->ExecuteQuery($sql, $params);
	if($res) {
	$this->output .= 'Kategorier sparades.';
	}
	else {
	$this->output .= 'Kategorier sparades EJ.<br><pre>' . print_r(parent::ErrorInfo(), 1) . '</pre>';
	}
      }
      }
      
      header('Location: edit.php?id=' . $this->id);
      exit;
      
      break;
    }
  }
  
  }
  
  public function deleteContent() {

 
 
  // Check that incoming parameters are valid
    isset($this->acronym) or die('Check: Logga in.');
    
    // Check if form was submitted 
  $this->output = null;
  if($this->delete == "Ta bort") {
  
  $sql = '
	UPDATE Content SET
	  published = ?,
	  updated = NOW(),
	  deleted = NOW()
	WHERE 
	  id = ?
      ';
      $params = array(null, $this->id);
      $res = $this->ExecuteQuery($sql, $params);
      
   header('Location: delete.php');
  }
  
    if($this->delete == "Radera") {
    
      
      //Remove category references first
      
      $sql = 'DELETE FROM Content2Cat WHERE contentid = ?';
      $params = array($this->id);
      $res = $this->ExecuteQuery($sql, $params);
       if($res) {
	$this->output .= 'Gamla kategorier togs bort. ';
      }
      else {
	$this->output .= 'Kategorier togs EJ bort.<br><pre>' . print_r(parent::ErrorInfo(), 1) . '</pre>';
      }
    
  
    $sql = 'DELETE FROM Content WHERE id = ? LIMIT 1';
    $this->ExecuteQuery($sql, array($this->id));
    $this->SaveDebug("Det raderades " . $this->RowCount() . " rader från databasen.");
    $this->output = "Det raderades " . $this->RowCount() . " rader från databasen.";
    header('Location: delete.php');
  }

}

public function setupContentAction()
{

    $this->db->setVerbose();
 
    $this->db->dropTableIfExists('content')->execute();
 
    $this->db->createTable(
        'content',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'title' => ['varchar(100)', 'not null'],
            'slug' => ['varchar(100)', 'unique'],
            'url' => ['varchar(100)', 'unique'],
            'type' => ['varchar(80)'],
            'data' => ['text'],
            'filter' => ['varchar(80)'],
            'acronym' => ['varchar(20)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'published' => ['datetime'],
        ]
    )->execute();
    /*
    $this->db->insert(
        'user',
        ['acronym', 'email', 'name', 'password', 'created', 'active']
    );
 
    $now = date('Y-m-d H:i:s');
 
    $this->db->execute([
        'admin',
        'admin@dbwebb.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
 
    $this->db->execute([
        'doe',
        'doe@dbwebb.se',
        'John/Jane Doe',
        password_hash('doe', PASSWORD_DEFAULT),
        $now,
        $now
     ]);
     
         $this->db->execute([
        'maria',
        'choklad@post.utfors.se',
        'Maria',
        password_hash('maria', PASSWORD_DEFAULT),
        $now,
        null
     ]);
     */
     /*
     $this->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'list',
        //'params'     => [],
    ]);
    */
    
}

}