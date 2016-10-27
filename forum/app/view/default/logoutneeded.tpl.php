<h1>Log out from account:</h1>
<hr class="style1">
<br>
<div class='comments'>

    <div class='button'>
        <a href='<?= $this->url->create('confirm/logout') ?>'>Log out</a>
    </div>
    <br><br><br><br>
</div>

<h1>Update your account:</h1>
<hr class="style1">

<br>
<div class='comments'>

    <div class='button'>
        <a href='<?= $this->url->create("users/update/{$id}") ?>'>Update user</a>
    </div>

</div>