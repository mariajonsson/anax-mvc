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
 
    $sidebar = $app->fileContent->get('theme-sidebar.md');
    $sidebar = $app->textFilter->doFilter($sidebar, 'shortcode, markdown');
    
    $triptych1 = $app->fileContent->get('theme-infogrid.md');
    $triptych1 = $app->textFilter->doFilter($triptych1, 'shortcode, markdown');
    
    $triptych3 = $app->fileContent->get('theme-infotypography.md');
    $triptych3 = $app->textFilter->doFilter($triptych3, 'shortcode, markdown');
    
    $triptych2 = $app->fileContent->get('theme-inforegions.md');
    $triptych2 = $app->textFilter->doFilter($triptych2, 'shortcode, markdown');
 
    $app->views->add('theme/plain', [ 'content' => $content, ], 'main');
    $app->views->add('theme/plain', [ 'content' => $sidebar, ], 'sidebar');
    $app->views->add('theme/info', [ 'content' => $triptych1, 'class' => 'info'], 'triptych-1');
    $app->views->add('theme/info', [ 'content' => $triptych2, 'class' => 'info' ], 'triptych-2');
    $app->views->add('theme/info', [ 'content' => $triptych3, 'class' => 'info' ], 'triptych-3');
    $app->views->add('theme/info', [ 'content' => '<a href="http://lesscss.org/">{less}</a>', 'class' => 'info2' ], 'footer-col-3');
    $app->views->add('theme/info', [ 'content' => '<a href="http://fortawesome.github.io/Font-Awesome/">Font Awesome</a>', 'class' => 'info2' ], 'footer-col-1');
    $app->views->add('theme/info', [ 'content' => '<a href="http://semantic.gs/">Semantic grid system</a>', 'class' => 'info2' ], 'footer-col-2');
    $app->views->add('theme/info', [ 'content' => '<a href="http://getbootstrap.com/">Bootstrap</a>', 'class' => 'info2' ], 'footer-col-4');

    

});

$app->router->add('regions', function() use ($app) {
 
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

$app->router->add('typography', function() use ($app) {
 
    $app->theme->setTitle("Typografi");
 
    $app->views->add('theme/typography', [], 'main');
    $app->views->add('theme/typography', [], 'sidebar');
    
});

$app->router->add('grid', function() use ($app) {
	
    $app->theme->setTitle("Rutnät");
 
    $content = $app->fileContent->get('theme.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $sidebar = $app->fileContent->get('theme-sidebar.md');
    $sidebar = $app->textFilter->doFilter($sidebar, 'shortcode, markdown');
    
    $triptych1 = $app->fileContent->get('theme-infogrid.md');
    $triptych1 = $app->textFilter->doFilter($triptych1, 'shortcode, markdown');
    
    $triptych3 = $app->fileContent->get('theme-infotypography.md');
    $triptych3 = $app->textFilter->doFilter($triptych3, 'shortcode, markdown');
    
    $triptych2 = $app->fileContent->get('theme-inforegions.md');
    $triptych2 = $app->textFilter->doFilter($triptych2, 'shortcode, markdown');
 
    $app->views->add('theme/plain', [ 'content' => $content, ], 'main');
    $app->views->add('theme/plain', [ 'content' => $sidebar, ], 'sidebar');
    $app->views->add('theme/info', [ 'content' => $triptych1, 'class' => 'info'], 'triptych-1');
    $app->views->add('theme/info', [ 'content' => $triptych2, 'class' => 'info' ], 'triptych-2');
    $app->views->add('theme/info', [ 'content' => $triptych3, 'class' => 'info' ], 'triptych-3');
    $app->views->add('theme/info', [ 'content' => '<a href="http://lesscss.org/">{less}</a>', 'class' => 'info2' ], 'footer-col-3');
    $app->views->add('theme/info', [ 'content' => '<a href="http://fortawesome.github.io/Font-Awesome/">Font Awesome</a>', 'class' => 'info2' ], 'footer-col-1');
    $app->views->add('theme/info', [ 'content' => '<a href="http://semantic.gs/">Semantic grid system</a>', 'class' => 'info2' ], 'footer-col-2');
    $app->views->add('theme/info', [ 'content' => '<a href="http://getbootstrap.com/">Bootstrap</a>', 'class' => 'info2' ], 'footer-col-4');
    
});

$app->router->add('fontawesome', function() use ($app) {
    $app->theme->setTitle("Font Awesome");
 
    $main = $app->fileContent->get('fa-examples.html');
    $sidebar = $app->fileContent->get('fa-enlarge.html');
 
    $app->views->add('me/page', [ 'content' => $main, ], 'main');
    $app->views->add('me/page', [ 'content' => $sidebar, ], 'sidebar');
    
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
