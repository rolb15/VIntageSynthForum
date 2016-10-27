<h1>All questions</h1>
<hr class="style1">

<?php
if (is_array($comments)) : ?>

<div class='comments'>
    <?php for ($i = sizeof($comments) - 1; $i >= 0; $i--) : ?>

        <?php $comment = $comments[$i]; ?>
        <?php $id = $comment->id; ?>

        <div class='comment'>

            <div class='head'>
                <strong><a href='<?= $this->url->create("comment/id/{$comment->id}") ?>'><?=$comment->header ?></a></strong>
            </div>

            <div class='grey'>asked by: </div>
            <div class='gravsmall'>
                <img src="https://www.gravatar.com/avatar/<?= $comment->hash ?>?d=retro" height='25' width='25'/>
            </div>
            <a href='<?= $this->url->create("users/id/{$comment->poster}") ?>'><?=$comment->name ?></a>
            <div class='date'><?= $comment->created ?> <br></div>

            <?php if ($comment->children!==null) {
                $childarray = explode(",", $comment->children);
                $responses = sizeof($childarray);
            } else {
                $responses = 0;
            }
            ?>

            <div class='right'><?= $responses ?>  answer(s)<br></div>
            <br>
        </div>
        <hr>
    <?php endfor; ?>

</div>

<br>

<?php endif; ?>



