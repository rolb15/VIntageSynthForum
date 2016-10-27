<?php
require __DIR__.'/config_with_app.php';

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

$app->session();

$di->set('CommentController', function () use ($di) {
    $controller = new Anax\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$di->set('UsersController', function () use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('TagsController', function () use ($di) {
    $controller = new \Anax\Tags\TagsController();
    $controller->setDI($di);
    return $controller;
});

$di->set('SetupController', function () use ($di) {
    $controller = new \Anax\Setup\SetupController();
    $controller->setDI($di);
    return $controller;
});

//$di->set('AuthenticateController', function () use ($di) {
//    $controller = new \Anax\Authenticator\AuthenticateController();
//    $controller->setDI($di);
//    return $controller;
//});

$di->set('ConfirmController', function () use ($di) {
    $controller = new \Anax\Confirmator\ConfirmController();
    $controller->setDI($di);
    return $controller;
});

$di->setShared('db', function () {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_sqlite.php');
    $db->connect();
    return $db;
});

$app->router->add('', function () use ($app) {

    $app->theme->setTitle("Home");

    $posts = $app->db->executeFetchAll('SELECT * FROM COMMENT WHERE page = "question" ORDER BY CREATED DESC LIMIT 3');

    $top = $app->db->executeFetchAll('SELECT name, poster, hash, COUNT(*) FROM COMMENT GROUP BY name ORDER BY COUNT(*) DESC LIMIT 3');

    $toptags = $app->db->executeFetchAll('SELECT ID, USES, NAME FROM TAGS ORDER BY USES DESC LIMIT 3');

    $app->views->add('comment/last', [
        'comments' => $posts,
        'top' => $top,
        'toptags' => $toptags,
    ]);

});

$app->router->add('questions', function () use ($app) {

    $app->theme->setTitle("All questions");

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action' => 'view',
        'params' => ['question', 'questions'],
    ]);
});

$app->router->add('new', function () use ($app) {

    $app->theme->setTitle("New question");

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action' => 'new',
        'params' => ['question', 'questions'],
    ]);
});

$app->router->add('tags', function () use ($app) {

    $app->theme->setTitle("Tags");

    $tags = $app->db->executeFetchAll('SELECT name, id FROM TAGS');

    $app->views->add('comment/tags', [
        'content' => $tags,
    ]);

});

$app->router->add('users/list', function () use ($app) {

    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'list',
    ]);

});

$app->router->add('login', function () use ($app) {

    $app->theme->setTitle("Log in/out");

    $app->dispatcher->forward([
        'controller' => 'confirm',
        'action' => 'login',
    ]);
});


$app->router->add('about', function () use ($app) {

    $app->theme->setTitle("About");

    $content = $app->fileContent->get('about.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
    ]);
});


$app->router->handle();
$app->theme->render();
