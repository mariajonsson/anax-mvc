<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 


 $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN); 

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_04.php');


$di->set('CommentsController', function() use ($di) {
    $controller = new Phpmvc\Comment\CommentsController();
    $controller->setDI($di);
    return $controller;
});
$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
    $db->connect();
    return $db;
});

$di->set('UsersController', function() use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('form', '\Mos\HTMLForm\CForm');

$app->session();

$app->router->add('', function() use ($app) {
 
    
    $app->theme->setTitle("Me");
 
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
 
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
    
    $formvisibility = $app->request->getPost('form');
    

    $app->dispatcher->forward([
        'controller' => 'comments',
        'action'     => 'view',
        'params'     => ['me-page', $formvisibility,''],
    ]);


 
});
 
$app->router->add('redovisning', function() use ($app) {

    $app->theme->setTitle("Redovisning");

    $content = $app->fileContent->get('redovisning.md');
    $content .= $app->fileContent->get('redovisning02.md');
    $content .= $app->fileContent->get('redovisning03.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/redovisning', [
        'content' => $content,
        'byline' => $byline,
    ]);
 
});

// Route to show welcome to dice
$app->router->add('dice', function() use ($app) {

    $app->theme->addStylesheet('css/dice.css');

    $app->views->add('dice/index');
    $app->theme->setTitle("Kasta tärning");

});

// Route to roll dice and show results
$app->router->add('dice/roll', function() use ($app) {

    $app->theme->addStylesheet('css/dice.css');

    // Check how many rolls to do
    $roll = $app->request->getGet('roll', 1);
    $app->validate->check($roll, ['int', 'range' => [1, 100]])
        or die("Kast utanför gränsen");

    // Make roll and prepare reply
    $dice = new \Mos\Dice\CDice();
    $dice->roll($roll);

    $app->views->add('dice/index', [
        'roll'      => $dice->getNumOfRolls(),
        'results'   => $dice->getResults(),
        'total'     => $dice->getTotal(),
    ]);

    $app->theme->setTitle("Tärningen kastad");

});

//Comments
$app->router->add('comments', function() use ($app) {

    $formvisibility = $app->request->getPost('form');
    
    $app->theme->setTitle("Kommentarer");
    $app->views->add('comment/index');
     

    $app->dispatcher->forward([
        'controller' => 'comments',
        'action'     => 'view',
        'params'     => ['comment-page', $formvisibility,'comments'],
    ]);

});
 
$app->router->add('source', function() use ($app) {
 
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Källkod");
 
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);
 
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
 
});

$app->router->add('users', function() use ($app) {
		$app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'list',
    ]);
});

$app->router->add('setup', function() use ($app) {
 
    //$app->db->setVerbose();
 
    $app->db->dropTableIfExists('user')->execute();
 
    $app->db->createTable(
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
    
    $app->db->insert(
        'user',
        ['acronym', 'email', 'name', 'password', 'created', 'active']
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $app->db->execute([
        'admin',
        'admin@dbwebb.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
 
    $app->db->execute([
        'doe',
        'doe@dbwebb.se',
        'John/Jane Doe',
        password_hash('doe', PASSWORD_DEFAULT),
        $now,
        $now
     ]);
     
         $app->db->execute([
        'maria',
        'choklad@post.utfors.se',
        'Maria',
        password_hash('maria', PASSWORD_DEFAULT),
        $now,
        null
     ]);
     
     $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'list',
        //'params'     => [],
    ]);
});

$app->router->add('setup-comment', function() use ($app) {
 
    $app->db->setVerbose();
 
    $app->db->dropTableIfExists('comments')->execute();
 
    $app->db->createTable(
        'comments',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'content' => ['text', 'not null'],
            'mail'   => ['varchar(80)'],
            'name'    => ['varchar(80)'],
            'pagekey' => ['varchar(80)'],
            'timestamp' => ['datetime'],
            'ip'      => ['varchar(80)'],
            'web'     => ['varchar(200)'],
            'gravatar' => ['varchar(200)']
            
        ]
    )->execute();
    
    $app->db->insert(
        'comments',
        ['content', 'mail', 'name', 'pagekey', 'timestamp', 'ip', 'web', 'gravatar']
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $app->db->execute([
        'En första kommentar',
        'admin@dbwebb.se',
        'Administrator',
        'comment-page',
        $now,
        '111.111.11',
        null,
        'http://www.gravatar.com/avatar/' . md5(strtolower(trim('admin@dbwebb.se'))) . '.jpg'
    ]);
    
        $app->db->execute([
        'Hej!',
        'admin@dbwebb.se',
        'Administrator',
        'me-page',
        $now,
        '111.111.11',
        null,
        'http://www.gravatar.com/avatar/' . md5(strtolower(trim('admin@dbwebb.se'))) . '.jpg'
    ]);
    
    
     $app->theme->setTitle("Kommentarer");
    $app->views->add('comment/index');
     $formvisibility = $app->request->getPost('form');
     $app->dispatcher->forward([
        'controller' => 'comments',
        'action'     => 'view',
        'params'     => ['comment-page', $formvisibility,'comment'],
    ]);
});
 
$app->router->handle();
$app->theme->render();
