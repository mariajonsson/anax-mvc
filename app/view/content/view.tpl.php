<h1>Innehåll</h1>
<p>
<?php if ($post->getProperties()['deleted'] != null) : ?>
Den här användaren är borttagen och kan inte redigeras. Gå till <a 
href="<?=$this->di->get('url')->create('users/discarded')?>">papperskorgen</a> 
för att återställa användaren eller för att radera användaren permanent.
<?php endif; ?>
</p>

<h4><?=$post->getProperties()['title']?></h4>
<p><?=$post->getProperties()['acronym']?></p>
<br><?=$post->getProperties()['data']?></p>
<p><?=$status?> <?=$date?>
<br>Skapades <?=$post->getProperties()['created']?>
<br><?=isset($post->getProperties()['updated'])?"Uppdaterad 
".$post->getProperties ( ) [ 'updated' ]:'';?></p>
<p>
<?php if ($post->getProperties()['deleted'] == null) : ?>
    <a 
href="<?=$this->url->create('content/update').'/'.$post->getProperties()['id']?>" 
title='Ändra'><i class="fa fa-pencil"></i> Redigera innehåll
</a>
<?php endif; ?>
</p>

