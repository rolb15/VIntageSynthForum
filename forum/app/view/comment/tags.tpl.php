<h1>Available tags</h1>
<hr class="style1">

<br>

<div class='comments'>
<div class='row'>
    <?php for ($i = 0; $i  < sizeof($content); $i++): ?>

        <?php $tag = $content[$i]; ?>

        <div class="tag">
            <a href='<?= $this->url->create("tags/id/{$tag->id}") ?>'><?=$tag->name ?></a>
        </div>

    <?php endfor; ?>
    </div>
</div>