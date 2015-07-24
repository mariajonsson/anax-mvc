<h2>Kommentarer</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<div class='comment'>
	<div class='comment-id'>
<a href='<?=$this->url->create('comment/edit/'.$pagekey.'/'.$id)?>'>#<?=$id?></a>
	</div>
	<div class='comment-content'>
	<p class='comment-header'><?=$comment['name']?> <?=$comment['timestamp']?></p>
	<p><?=$comment['content']?></p>
	<p class='comment-ip'><?=$comment['ip']?></p>
	</div>
</div>
<div class='comment-divider'></div>
<?php endforeach; ?>
</div>
<?php endif; ?>