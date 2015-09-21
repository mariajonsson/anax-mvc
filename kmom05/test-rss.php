<?php
require __DIR__.'/config_with_app.php';
 $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN); 

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_05.php');

$di->setShared('rss', function() {
    $rss = new \Anax\RSS\RSS();
    return $rss;
});



$app->router->add('', function() use ($app) {
  $xml = "http://dbwebb.se/forum/feed.php";
  $xmlDoc = new DOMDocument();
  $xmlDoc->load($xml);

  $app->theme->setVariable('title', "RSS Flöde")
         ->setVariable('main', "<h2>Senaste nytt/ändrat från " . $app->rss->setupAndGetTitle($xmlDoc) . " forumet</h2>");


  $app->views->addString($app->rss->getContent($xmlDoc), 'main');

});

$app->router->handle();
$app->theme->render();
