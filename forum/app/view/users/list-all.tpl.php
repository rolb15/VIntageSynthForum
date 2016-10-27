<h1><?= $title ?></h1>
<hr class="style1">

<div class='comments'>
<?php
if (count($users) != 0) : ?>

    <table>

    <?php foreach ($users as $user) : ?>

        <tr>
            <td><img src="https://www.gravatar.com/avatar/<?= $user->hash ?>?d=retro" height='35' width='35'/></td>
            <td><a href='<?= $this->url->create("users/id/{$user->id}") ?>'><?= $user->acronym?></a></td>
        </tr>

    <?php endforeach; ?>

<?php endif; ?>

<?php if (count($users) == 0) : ?>
    No users.
<?php endif; ?>

</table>
</div>