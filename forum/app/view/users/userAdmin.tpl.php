<div id="user-admin">
    <h1><?= $title ?></h1>
    <h2><?= $subtitle ?></h2>

    <a href="<?=$this->di->get('url')->create('users')?>"> Visa alla användare</a>
    <a href="<?=$this->di->get('url')->create('users/add')?>"> Lägg till ny användare</a>
    <a href="<?=$this->di->get('url')->create('users/active')?>"> Visa aktiva användare</a>
    <a href="<?=$this->di->get('url')->create('users/inactive')?>"> Visa inaktiva användare</a>
    <a href="<?=$this->di->get('url')->create('users/discarded')?>"> Visa borttagna användare i papperskorgen</a>
    <a href="<?=$this->di->get('url')->create('users/resetDb')?>"> Återställ databasen</a>

</div>