
<div class='comments'>
<h3>Kommentarer</h3>
<?php if (is_array($comments)) : ?>
<?php $comments = array_reverse($comments) ?>
<?php foreach ($comments as $id => $comment) : ?>
<div class='comment'>
<div class='comment-id'>
<a href='<?=$this->url->create('comment/edit/'.$pagekey.'/'.$id.'/'.$redirect)?>'>#<?=$id?></a> <img src='<?=$comment['gravatar']?>?s=40'>
</div>
<div class='comment-content'>
<p class='comment-header'><a href='mailto:<?=$comment['mail']?>' class='comment-name'><?=$comment['name']?></a> skrev för 
<?php $elapsedsec = (time()-$comment['timestamp']); ?>
<?php if (($elapsedsec) < 60): ?>
<?=round($elapsedsec)?> s sedan
<?php elseif (($elapsedsec/60) < 60): ?>
<?=round($elapsedsec/60)?> minuter sedan
<?php elseif (($elapsedsec/(60*60)) < 24): ?>
<?=round($elapsedsec/(60*60))?> h sedan
<?php elseif (($elapsedsec/(60*60*24)) < 7): ?>
<?=round($elapsedsec/(60*60*24))?> dygn sedan
<?php elseif (($elapsedsec/(60*60*24)) < 30) : ?>
<?=round($elapsedsec/(60*60*24*7))?> veckor sedan
<?php else : ?>
<?=round($elapsedsec/(60*60*24*30))?> månader sedan
<?php endif; ?>
</p>
<p><?=$comment['content']?></p>
<p class='comment-ip'><?=$comment['ip']?></p>
</div>
</div>
<div class='comment-divider'></div>
<?php endforeach; ?>

<?php endif; ?>
<?php if (is_string($comments)) : ?>

<p class='comment'><?=$comments?></p>

<?php endif; ?>
</div>