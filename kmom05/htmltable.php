<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 


// $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN); 

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
//$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_theme.php');

$di->set('table', '\Meax\HTMLTable\HTMLTable');


$app->router->add('', function() use ($app) {

    $columns = array([
      'name' => 'fruits',
      'label' => 'Fruits',
      'sortable' => true,
    ],
    [
      'name' => 'animals',
      'label' => 'Animals',
      //'sortable' => false,
    ],
    );
    
    $data = array(
      1 => [
      $columns[0]['name'] => 'Apple', 
      $columns[1]['name'] => 'Horse' 
       ],
      2 => [
      $columns[0]['name'] => 'Banana', 
      $columns[1]['name'] => 'Monkey' 
       ],
    );

    $html = $app->table->createTable($columns, $data, array());
 
    $app->theme->setTitle("HTMLTable");
 
    $app->views->add('default/page', [
        'title' => "Try HTMLTable",
        'content' => $html
    ]);
    
});

 
$app->router->handle();
$app->theme->render();
