<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
 
$app->router->add('', function() use ($app) {
 
});
 
$app->router->add('redovisning', function() use ($app) {
	
	$app->theme->setTitle("Redovisning");
    $app->views->add('me/redovisning');
 
});
 
$app->router->add('source', function() use ($app) {
 
});
 
$app->router->handle();
$app->theme->render();
