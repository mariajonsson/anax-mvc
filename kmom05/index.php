<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 


 $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN); 

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_05.php');


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

$di->set('ContentController', function() use ($di) {
    $controller = new \Meax\Content\ContentController();
    $controller->setDI($di);
    return $controller;
});

$di->setShared('rss', function() {
    $rss = new \Anax\RSS\RSS();
    return $rss;
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
    $content .= $app->fileContent->get('redovisning04.md');
    $content .= $app->fileContent->get('redovisning05.md');
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
 
    $app->theme->setTitle("Återställ databasen");
    $app->views->add('users/reset-users', [
        'title' => "Återställ databas",
    ], 'main');
    $app->views->add('users/adminmenu', [], 'sidebar');
});


$app->router->add('setup-comments', function() use ($app) {
 
    $app->theme->setTitle("Återställ kommentarer");
    $app->views->add('comment/setup');
    
  
});

$app->router->add('delete-comments', function() use ($app) {
 
    $app->theme->setTitle("Radera kommentarer");
    $app->views->add('comment/delete');
    
  
});

$app->router->add('content', function() use ($app) {
		$app->dispatcher->forward([
        'controller' => 'content',
        'action'     => 'list',
    ]);
});


$app->router->add('setup-content', function() use ($app) {
 
    $app->theme->setTitle("Återställ innehåll");
    $app->views->add('content/setup', [
        'controller' => 'content',
        'title' => "Återställ databas",
    ], 'main');

});


$app->router->add('modules', function() use ($app) {

  $xml = "http://dbwebb.se/forum/feed.php";
  $xmlDoc = new DOMDocument();
  $xmlDoc->load($xml);



    $content = $app->fileContent->get('moduler.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $app->theme->setTitle("Moduler");
    $app->views->add('default/page', [
        'title' => "Egenutvecklade moduler",
        'content' => $content,
    ], 'main');
    $app->views->addString('<h2>Installerad modul</h2><p>I uppgiften ingick även att installera en modul som gjorts av någon annan i kursen. Jag har installerat en modul för RSS-flöden: emmtho/rss. <a href="test-rss.php">Klicka här för att se</a>.', 'sidebar');
    //$app->views->addString("<article class='smaller'><h4>RSS-flöde från " . $app->rss->setupAndGetTitle($xmlDoc) . " forumet</h4>". $app->rss->getContent($xmlDoc)."</article>", 'sidebar');
    
    

});

 
$app->router->handle();
$app->theme->render();
