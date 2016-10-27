<?php
namespace Anax\Users;

class UsersController implements \Anax\DI\IInjectionAware
{

    use \Anax\DI\TInjectable;


    public function initialize()
    {
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
    }



    public function menuAction()
    {
        $all = $this->users->findAll();

        $this->theme->setTitle("Menu");
        $this->views->add('users/menu', [
            'title' => "Menu",
        ]);
    }



    public function listAction()
    {
        $all = $this->users->findAll();

        $this->theme->setTitle("All users");

        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "All users",
        ]);
    }


    public function indexAction()
    {
        $this->theme->setTitle("User routes");
        $this->views->add('users/menu');
    }


    public function idAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }
        $user = $this->users->find($id);
        $this->theme->setTitle("View user with id");

        $sql = 'SELECT id, header, created, page, parent FROM COMMENT WHERE poster = ' . $id;
        $comments = $this->db->executeFetchAll($sql);

        //$hash = md5(strtolower(trim($user->email)));

        //echo $hash;

        $this->views->add('users/view', [
            'user' => $user,
            'comments' => $comments,
        ]);
    }


    public function addAction()
    {
        $this->di->session();
        $form = new \Anax\HTMLForm\CFormAddUser();
        $form->setDI($this->di);
        $form->check();

        $this->di->theme->setTitle("Add user");

        $this->di->views->add('default/signpage', [
            'title' => "Add a new User",
            'content' => $form->getHTML()
        ]);
    }


    public function deleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }
        $res = $this->users->delete($id);
        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }


    public function softDeleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }
        $now = gmdate('Y-m-d H:i:s');
        $user = $this->users->find($id);

        $user->deleted = $user->deleted == null ? $now : null;
        $user->save();

        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }


    public function activeAction()
    {
        $all = $this->users->query()->where('active IS NOT NULL')->andWhere('deleted is NULL')->execute();

        $this->theme->setTitle("Active Users");

        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Active Users",
        ]);
    }


    public function inactiveAction()
    {
        $all = $this->users->query()->where('active is NULL')->execute();

        $this->theme->setTitle("Inactive Users");

        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Inaktiva användare",
        ]);
    }


    public function deletedAction()
    {
        $all = $this->users->query()->where('deleted IS NOT NULL')->execute();

        $this->theme->setTitle("Softdeleted Users");

        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Borttagna användare",
        ]);
    }


    public function activationAction($id = null)
    {
        if (!isset($id)) {
            die("Doesn't exist");
        }
        $now = gmdate('Y-m-d H:i:s');
        $user = $this->users->find($id);
        $user->active = $user->active == null ? $now : null;
        $user->save();
        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }


    public function updateAction($id = null)
    {
        if (!isset($id)) {
            die("Doesn't exist");
        }
        $this->di->session();
        $user = $this->users->find($id);

        $form = new \Anax\HTMLForm\CFormUpdateUser($user);
        $form->setDI($this->di);
        $form->check();

        $this->di->theme->setTitle("Update user");

        $this->di->views->add('default/update', [
            'title' => "Update user",
            'content' => $form->getHTML()
        ]);
    }
}
