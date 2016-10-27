<h1> User Info </h1>
<hr class="style1">

<br>
<div class='comments'>

    <img src="https://www.gravatar.com/avatar/<?= $user->hash ?>?d=retro" height='45' width='45'/>
    <br>

    <h3><?= $user->acronym ?></h3>

    Email: <?= $user->email ?>.
    <br><br>

    <h3>Questions by user:</h3>
    <hr class="style1">

    <?php for ($i = 0; $i  < sizeof($comments); $i++): ?>

        <?php $comment = $comments[$i]; ?>
        <?php $id = $comment->id; ?>

        <?php if ($comment->page == 'question'):?>

        <div class='head'>
            <a href='<?= $this->url->create("comment/id/{$comment->id}") ?>'><?=$comment->header ?></a>
        </div>

        <?php endif; ?>

    <?php endfor; ?>
    <br>

    <h3>Comments by user:</h3>
    <hr class="style1">

    <?php for ($i = 0; $i  < sizeof($comments); $i++): ?>

        <?php $comment = $comments[$i]; ?>
        <?php $id = $comment->parent; ?>

        <?php if ($comment->page == 'comment'):?>

        <div class='head'>
            <a href='<?= $this->url->create("comment/id/{$comment->id}") ?>'><?=$comment->header ?></a>
        </div>

        <?php endif; ?>

    <?php endfor; ?>


</div>
