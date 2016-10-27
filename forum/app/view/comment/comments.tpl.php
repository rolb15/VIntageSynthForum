

<?php if (is_array($comments)) : ?>

<div class="comments">
    <header class="Comments_header">
        <h5 class="Comments_title">Comments (<span><?=count($comments)?></span>)</h5>
    </header>
    <div class="Comments_content">
        <?php foreach ($comments as $id => $comment) : ?>
        <article class="Comment">

            <div class="Comment_body">
                <header class="Comment_header">
                    <p class="Comment_title"><a href="<?=$this->url->create('acomment/editor/' . $id . '/' . $page)?>">Edit comment</a> by <a href="mailto:<?=$comment['mail']?>"><?=$comment['name']?></a> </p>
                    <p class="Comment_id">Webbpage: <?=$comment['web']?></p>
                </header>
                <p><?=$comment['content']?></p>
                <footer class="Comment_footer">
                    <p class="Comment_time"><?=date('Y-m-d', $comment['timestamp'])?></p>
                    <hr>
                </footer>
            </div>
        </article>
        <?php endforeach;?>
    </div>
</div>
<?php endif; ?>



