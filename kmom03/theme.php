<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 


 $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN); 

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_theme.php');



$app->router->add('', function() use ($app) {
 
    $app->theme->setTitle("Tema");
 
    $content = $app->fileContent->get('theme.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
 
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
    
    
 
});

$app->router->add('', function() use ($app) {
 
    $app->theme->setTitle("Tema");
 
    $content = $app->fileContent->get('theme.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
 
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);

});

$app->router->add('regions', function() use ($app) {
 
    $app->theme->addStylesheet('css/anax-grid/regions_demo.css');
    $app->theme->addStylesheet('css/anax-grid/grid_demo.css');
    $app->theme->setTitle("Regioner");
 
    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
    
});

$app->router->add('grid', function() use ($app) {
 
    $app->theme->addStylesheet('css/anax-grid/grid_demo.css');
    $app->theme->setTitle("Rutnät");
 
    $content = $app->fileContent->get('theme.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $app->views->add('me/page', [
        'content' => $content,

    ]);
    
});

$app->router->add('typography', function() use ($app) {
 
    $app->theme->setTitle("Typografi");
 
    $content = $app->fileContent->get('theme.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $app->views->add('me/page', [
        'content' => $content,

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
