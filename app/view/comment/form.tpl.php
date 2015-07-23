<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create($redirect)?>">
        <!--input type="hidden" name="pagekey" value="<?=$pagekey?>"/-->
        <fieldset>
        <legend>Lämna en kommentar</legend>
        <p><label>Kommentar:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Namn:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Hemsida:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Epost:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <input type='submit' name='doCreate' value='Kommentera' onClick="this.form.action = '<?=$this->url->create('comment/add/'.$pagekey)?>'"/>
            <input type='reset' value='Återställ'/>
            <input type='submit' name='doRemoveAll' value='Radera alla' onClick="this.form.action = '<?=$this->url->create('comment/remove-all')?>'"/>
        </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
