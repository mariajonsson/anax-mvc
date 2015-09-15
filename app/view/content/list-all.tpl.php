
<div class='content'>
<!--<pre><?php echo var_dump($content); ?></pre>-->
<h3>Innehåll</h3>
<?php if (is_array($content)) : ?>
<?php /*$content = array_reverse($content)*/ ?>
<?php foreach ($content as $id => $post) : ?>
<?php $id = (is_object($post)) ? $post->id : $id; ?>
<?php $post = (is_object($post)) ? get_object_vars($post) : $post; ?> 
 
<div class='comment'>
<div class='comment-id'>
</div>
<div class='comment-content'>
<p class='comment-header'><?=$post['title']?>
<br><?=$post['published']?></p>
<p><?=$post['data']?></p>
<p class='comment-footer'>
<?php if (!empty($post['updated'])) : ?>
Redigerades <?=$post['updated']?>
<?php endif; ?>
</p>
</div>
</div>
<div class='comment-divider'></div>
<?php endforeach; ?>

<?php endif; ?>
<?php if (is_string($content)) : ?>

<p class='comment'><?=$content?></p>

<?php endif; ?>
</div>

