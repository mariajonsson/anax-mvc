<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config_with_app.php'; 



// Demonstration of application specific module CDice
$dice = new \Mos\Dice\CDice();

// Check how many rolls to do
$roll = isset($_GET['roll']) && is_numeric($_GET['roll']) 
    ? $_GET['roll'] 
    : 0;

if($roll > 100) {
    throw new Exception("To many rolls on the dice. Not allowed.");
}



// Make roll and prepare reply
$html = null;
if($roll) {
    $dice->roll($roll);

    $html = "<p>You made {$roll} roll(s) and you got this serie.</p>\n<ul class='dice'>";
    foreach($dice->getResults() as $val) {
        $html .= "\n<li class='dice-{$val}'></li>";
    }
    $html .= "\n</ul>\n";

    $html .= "<p>You got " . $dice->getTotal() . " as a total.</p>";
}



// Prepare the page content

$app->theme->addStylesheet("css/dice.css")
           ->setVariable('title', "Kasta tärning")
           ->setVariable('main', "
    <h1>Kasta en tärning</h1>
    <p>Hur många kast vill du göra, <a href='?roll=1'>1 kast</a>, <a href='?roll=3'>3 kast</a> or <a href='?roll=6'>6 kast</a>? </p>
    $html
");



// Render the response using theme engine.
$app->theme->render();
