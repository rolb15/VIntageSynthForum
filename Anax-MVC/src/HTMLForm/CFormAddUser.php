<?php
namespace Anax\HTMLForm;

class CFormAddUser extends \Mos\HTMLForm\CForm {

    use \Anax\DI\TInjectionAware, \Anax\MVC\TRedirectHelpers;

    public function __construct() {
        parent::__construct([], [
            'acronym' => [
            'type' => 'text',
            'label' => 'Username:',
            'required' => true,
            'validation' => ['not_empty'],
            ],
            'email' => [
                'type' => 'text',
                'required' => true,
                'validation' => ['not_empty', 'email_adress'],
            ],

            'password' => [
                'type' => 'password',
                'label' => 'Password:',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'submit' => [
                'type' => 'submit',
                'callback' => [$this, 'callbackSubmit'],
            ],
        ]);
    }

    public function check($callIfSuccess = null, $callIfFail = null) { return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']); }

    public function callbackSubmit() {

        $now = gmdate('Y-m-d H:i:s');
        $users = new \Anax\Users\User();
        $users->setDI($this->di);

        $hash = md5(strtolower(trim($this->Value('email'))));

        $result = $users->save([
            'acronym' => $this->Value('acronym'),
            'name' => $this->Value('acronym'),
            'email' => $this->Value('email'),
            'hash' => $hash,
            'password' => password_hash($this->Value('password'), PASSWORD_DEFAULT),
            'created' => $now,
            'active' => $now,
        ]);

        return $result;
    }

    public function callbackSuccess()
    {
        $url = $this->di->url->create('users/list');
        $this->di->response->redirect($url);
    }

    public function callbackFail() { $this->AddOutput("<p><i>Something went wrong when processing the form.</i></p>"); $this->redirectTo(); } }