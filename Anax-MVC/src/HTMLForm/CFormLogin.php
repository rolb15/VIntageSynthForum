<?php
namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormLogin extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionAware,
        \Anax\MVC\TRedirectHelpers;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct([], [
            'acronym' => [
                'type'        => 'text',
                'label'       => 'Username:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'password' => [
                'type'        => 'password',
                'label'       => 'Password',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'submit' => [
                'type'      => 'submit',
                'value'     => 'Log in',
                'callback'  => [$this, 'callbackSubmit'],
            ],
        ]);
    }

    /**
     * Customise the check() method.
     *
     * @param callable $callIfSuccess handler to call if function returns true.
     * @param callable $callIfFail    handler to call if function returns true.
     */
    public function check($callIfSuccess = null, $callIfFail = null)
    {
        return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
    }

    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmit()
    {
        $confirmator = new \Anax\Confirmator\Confirmator();
        $confirmator->setDI($this->di);

        $now = gmdate('Y-m-d H:i:s');
        $result = $confirmator->tryLogin($this->Value('acronym'), $this->Value('password'));

        return $result;
    }

    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        $this->redirectTo('');
    }
    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput('Wrong login!');
        $this->redirectTo();
    }
}