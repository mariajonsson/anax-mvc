<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 


 $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN); 

$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_04.php');

$di->set('CommentController', function() use ($di) {
    $controller = new Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});
$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_sqlite.php');
    $db->connect();
    return $db;
});

/* $app->router->add('', function() use ($app) {
 
}); */

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
        'controller' => 'comment',
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
$app->router->add('comment', function() use ($app) {
		
    $app->theme->setTitle("Kommentarer");
    $app->views->add('comment/index');
    
    $formvisibility = $app->request->getPost('form');

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
        'params'     => ['comment-page', $formvisibility,'comment'],
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
 
$app->router->handle();
$app->theme->render();
