<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 

$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
    $db->connect();
    return $db;
});

$di->set('ContentBasicController', function() use ($di) {
    $controller = new \Meax\Content\ContentBasicController();
    $controller->setDI($di);
    return $controller;
});


$app->router->add('', function() use ($app) {

    $app->theme->setTitle("Setup content");

    $app->views->add('content/basic-setup', [
        'controller' => 'content-basic',
    ]);
});



 
$app->router->handle();
$app->theme->render();
