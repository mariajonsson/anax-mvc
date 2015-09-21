<?php

namespace Anax\RSS;

/**
 * Model for Users.
 *
 */
 class RSS
 {

   //sätter iordning och hämtar den stora titlen
   public function setupAndGetTitle($xmlDoc){
     //var_dump($xmlDoc->saveXML());
     $channel=$xmlDoc->getElementsByTagName('feed')->item(0);
     //var_dump($channel);
     $channel_title = $channel->getElementsByTagName('title')
     ->item(0)->childNodes->item(0)->nodeValue;
     return ($channel_title);
   }

   //Hämtar alla events
   public function getContent($xmlDoc){
     $x=$xmlDoc->getElementsByTagName('entry');

     $allItems = null;
     for ($i=0; $i<=2; $i++) {
       $item_title=$x->item($i)->getElementsByTagName('title')
       ->item(0)->nodeValue;
       $item_link=$x->item($i)->getElementsByTagName('link')
       ->item(0)->nodeValue;
       $item_content=$x->item($i)->getElementsByTagName('content')
       ->item(0)->nodeValue;
       $allItems .= "<h3><a href='" . $item_link . "'>" . $item_title . "</a></h3><br>" . $item_content;
   }
   return $allItems;
 }

 }
