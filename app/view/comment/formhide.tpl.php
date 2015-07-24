<div class='comment-form'>
<form method=post id='hide-form'>
<fieldset>
<input type=hidden name="redirect" value="<?=$this->url->create($redirect)?>">
<input type="hidden" name="pagekey" value="<?=$pagekey?>">
<input type="hidden" name="form" value="show-form">
<legend><a href='#' onclick="document.getElementById('hide-form').submit();">Lämna en kommentar</a></legend>
</fieldset>
</form>
</div>