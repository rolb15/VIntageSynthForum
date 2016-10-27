

    <div class='head'>
        <a href='<?= $this->url->create("comment/id/{$root[0]->id}") ?>'>Subject: <strong><?= $question->header ?></strong></a>
    </div>

    <hr class="style1">

        <div class="row">
            <?php if (!empty($tags[0])) : ?>
                <?php for ($i = 0; $i  < sizeof($tags); $i++): ?>

                    <div class='tagsmall'><?= $tags[$i] ?></div>

                <?php endfor; ?>
            <?php endif; ?>

    </div>
    <hr>
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

    <div class="row">

        <div class='tagsmall'><?= $responses ?> answer(s)</div>
        <div class='button'>
            <a href='<?= $this->url->create("comment/reply/{$question->id}") ?>'>REPLY</a>
        </div>

    </div>
    <hr class="style1">


