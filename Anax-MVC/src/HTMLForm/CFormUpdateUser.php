<?php
namespace Anax\HTMLForm;

class CFormUpdateUser extends \Mos\HTMLForm\CForm {

    use \Anax\DI\TInjectionAware, \Anax\MVC\TRedirectHelpers;

    public function __construct($user)
    {
        $this->loggedInId = $user->id;

        parent::__construct([], [
            'acronym' => [
                'type' => 'text',
                'label' => 'Användarnamn:',
                'required' => true,
                'value' => $user->acronym,
                'validation' => ['not_empty'], ],
                'id' => [
                'type' => 'hidden',
                'required' => true,
                'value' => $user->id,
                'validation' => ['not_empty'],
            ],
            'name' => [
                'type' => 'text',
                'label' => 'Namn',
                'required' => true,
                'value' => $user->name,
                'validation' => [
                'not_empty'],
            ],
            'password' => [
                'type' => 'password',
                'label' => 'Lösenord',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'submit' => [
            'type' => 'submit',
            'callback' => [$this, 'callbackSubmit'],
            ],
        ]);
    }

    public function check($callIfSuccess = null, $callIfFail = null)
    {
        return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
    }

    public function callbackSubmit()
    {

        $now = gmdate('Y-m-d H:i:s');

        $users = new \Anax\Users\User();
        $users->setDI($this->di);

        $result = $users->save([
            'id' => $this->Value('id'),
            'acronym' => $this->Value('acronym'),
            'name' => $this->Value('name'),
            'password' => password_hash($this->Value('password'), PASSWORD_DEFAULT),
            'updated' => $now,
        ]);

        $this->di->db->execute("UPDATE COMMENT SET name = '" . $this->Value('acronym') . "' WHERE poster = " . $this->loggedInId);

        return $result;
    }

    public function callbackSuccess()
    {
        $url = $this->di->url->create('users/list');
        $this->di->response->redirect($url);
    }

    public function callbackFail()
    {
        $this->AddOutput("<p><i>Something went wrong when processing the form.</i></p>");
        $this->redirectTo();
    }
}