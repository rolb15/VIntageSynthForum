<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$page == 'a' ? $this->url->create('acomment/') : $this->url->create('bcomment/')?>">
        <input type=hidden name="page" value="<?=$page?>">

        <fieldset>
        <legend>Leave a comment</legend>
        <p><label>Comment:<br/> <textarea name='content' required><?=$content?></textarea></label></p>
        <p><label>Name:<br/><input type='text' name='name' value='<?=$name?>'/required></label></p>
        <p><label>Homepage:<br/><input type='url' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<br/><input type='email' name='mail' value='<?=$mail?>'/required></label></p>
        <p class=buttons>
            <input type='submit' name='doCreate' value='Comment' onClick="this.form.action = '<?=$this->url->create('acomment/add')?>'"/>
            <input type='reset' value='Reset'/>
            <input type='submit' name='doRemoveAll' value='Remove all' onClick="this.form.action = '<?=$this->url->create('acomment/remove-all/' . $page)?>'"/>
        </p>

        </fieldset>
    </form>
</div>
