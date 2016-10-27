
<div class='head'>
    <a href='<?= $this->url->create("comment/id/{$root[0]->id}") ?>'>Subject: <strong><?= $question->header ?></strong></a>
</div>

<hr class="style1">

<div class='user'>
    By: <a href='<?= $this->url->create("users/id/{$question->poster}") ?>'><strong><?=$question->name ?></strong></a>
    <div class='date'><?= $question->created ?></div>
</div>

<div class="rowB">

    <div class="gravatar">
        <img src="https://www.gravatar.com/avatar/<?= $question->hash ?>?d=retro" height='30' width='30'/>
    </div>
    <div class='text'>
        <?= $filtered ?>
    </div>
</div>

<hr class="style1">


