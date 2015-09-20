<article>

<h4><?=$post->getProperties()['title']?></h4>
<p>By <?=$post->getProperties()['acronym']?></p>
<p><?=$post->getProperties()['data']?></p>

<p>Created <?=$post->getProperties()['created']?>
<?=isset($post->getProperties()['updated'])?"<br>Edited 
".$post->getProperties ( ) [ 'updated' ]:'';?>
<?=isset($post->getProperties()['published'])?"<br>Published  
".$post->getProperties ( ) [ 'published' ]:'';?></p>
<p>
<?php if ($post->getProperties()['deleted'] == null) : ?>
    <a 
href="<?=$this->url->create('content-basic/update').'/'.$post->getProperties()['id']?>" 
title='Edit'>Edit contents
</a>
<?php endif; ?>
</p>
</article>
