<?php
namespace Anax\Confirmator;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class ConfirmController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {
    }

    public function loginAction()
    {
        $this->di->theme->setTitle("Log in");

        if ($this->confirmator->isUserLoggedIn()) {

            $this->views->add('default/logoutneeded', [
                'id' => $this->confirmator->isUserLoggedIn(),
            ]);

        } else {

            $form = new \Anax\HTMLForm\CFormLogin();
            $form->setDI($this->di);
            $form->check();

            $this->di->views->add('default/loginpage', [
                'title' => "Log in",
                'content' => $form->getHTML()
            ]);
        }
    }

    public function logoutAction()
    {
        $this->theme->setTitle("Logga ut");

        $this->confirmator->logout();
        $this->di->views->addString("You have been logged out.");
    }
}