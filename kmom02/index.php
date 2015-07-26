<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 


/* $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN); */

$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_02.php');

$di->set('CommentController', function() use ($di) {
    $controller = new Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
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
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	
    $app->views->add('me/redovisning', [
        'content' => $content,
    ]);
 
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
