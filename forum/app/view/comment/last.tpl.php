<?php
if (is_array($comments)) : ?>

<h1>New questions</h1>
<hr class="style1">
    <div class='comments'>

        <?php for ($i = 0; $i  < sizeof($comments); $i++): ?>

        <?php $comment = $comments[$i]; ?>
        <?php $id = $comment->id; ?>

        <?php if ($comment->children!==null) {
            $childarray = explode(",", $comment->children);
            $responses = sizeof($childarray);
            } else {
                $responses = 0;
            }
        ?>

        <div class='comment'>

            <div class='head'>
                <a href='<?= $this->url->create("comment/id/{$comment->id}") ?>'><?=$comment->header ?></a>
            </div>
            <div><?= $responses ?>  answer(s)<br></div>

            <div class='grey'>asked by:
                <a href='<?= $this->url->create("users/id/{$comment->poster}") ?>'><?=$comment->name ?></a>
            </div>
            <div class='date'><?= $comment->created ?> </div>
            <hr>
        </div>
        <?php endfor; ?>
    </div>
    <br>

<?php endif;

if (is_array($comments)) : ?>

<h1>Top posters</h1>
<hr class="style1">
    <div class='comments'>

        <?php for ($i = 0; $i < sizeof($top); $i++) : ?>

        <div class='comment'>

            <div class='gravsmall'>
                <img src="https://www.gravatar.com/avatar/<?= $top[$i]->hash ?>?d=retro" height='25' width='25'/>
            </div>
            <a href='<?= $this->url->create("users/id/{$top[$i]->poster}") ?>'><?=$top[$i]->name?></a>
            <?=$top[$i]->{"COUNT(*)"};?> post(s)

        </div>
        <?php endfor; ?>
    </div>
    <br>

<?php endif;

if (is_array($toptags)) : ?>

<h1>Top tags</h1>
<hr class="style1">

    <div class='comments'>

        <div class='row'>
        <?php for ($i = 0; $i < sizeof($toptags); $i++) : ?>

            <div class="tag">
                <a href='<?= $this->url->create("tags/id/{$toptags[$i]->id}") ?>'><?=$toptags[$i]->name?></a>
            </div>

        <?php endfor; ?>
    </div>
    <br>

    </div>
 <hr class="style1">

<?php endif; ?>

<br><br>


