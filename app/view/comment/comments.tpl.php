<hr>

<h2>Kommentarer</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<h4>Kommentar #<a href='<?=$this->url->create('comment/edit/'. $id )?>'><?=$id?></a></h4>
<p><?=$comment['name']?>: </p>
<p><?=$comment['content']?></p>
<p><?=$comment['timestamp']?></p>
<p><?=$comment['ip']?></p>
<?php endforeach; ?>
</div>
<?php endif; ?>