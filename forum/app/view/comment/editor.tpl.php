<div class='editor-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$page == 'a' ? $this->url->create('acomment/') : $this->url->create('bcomment/')?>">
        <input type=hidden name="page" value="<?=$page?>">
        <fieldset>
            <legend><?=$legend?></legend>
            <p><label><?=$name_name?>:<br/><input type='text' name='name' value='<?=$name?>'/required></label></p>
            <p><label><?=$mail_name?>:<br/><input type='email' name='mail' value='<?=$mail?>'/required></label></p>
            <p><label><?=$web_name?>:<br/><input type='url' name='web' value='<?=$web?>'/></label></p>
            <p><label><?=$content_name?>:<br/><textarea name='content' required><?=$content?></textarea></label></p>
            <p class=buttons>
                <input type='submit' name='doSave' value='Spara' onClick="this.form.action = '<?=$this->url->create('acomment/save/' . $id . '/' . $page)?>'"/>
                <input type='submit' name='doDelete' value='Ta bort' onClick="this.form.action = '<?=$this->url->create('acomment/delete/' . $id . '/' . $page)?>'"/>
            </p>
        </fieldset>
    </form>
</div>