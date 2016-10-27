
<div style='margin-left:<?= $inset ?>px;'>

    <div class='user'>
        By: <strong><?= $answer->name ?></strong>
        <div class='date'><?= $answer->created ?></div>
    </div>

    <div class="rowB">
        <div class="gravatar">
            <img src="https://www.gravatar.com/avatar/<?= $answer->hash ?>?d=retro" height='30' width='30'/>
        </div>
        <div class='text'>
            <?= $filtered ?>
        </div>
    </div>

    <br>
    <div class="row">

        <div class='tagsmall'>
            <a href='<?= $this->url->create("comment/id/{$answer->id}") ?>'><?= $responses ?> comment(s)</a>
        </div>

        <div class='button'>
            <a href='<?= $this->url->create("comment/reply/{$answer->id}") ?>'>REPLY</a>
        </div>

    </div>

    <hr class="style1">
</div>
