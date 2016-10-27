<hr class="style1">

<div class='comments'>
<?php for ($i = 0; $i<sizeof($content); $i++): ?>

    <div class='head'>
        <a href='<?= $this->url->create("comment/id/{$content[$i]->id}") ?>'><?=$content[$i]->header ?></a>
    </div>

<?php endfor; ?>
</div>