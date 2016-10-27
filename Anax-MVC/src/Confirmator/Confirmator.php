<?php
namespace Anax\Confirmator;
/**
 * Authenticator used to log in and check if a user is logged in
 *
 */
class Confirmator implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    private $loggedInUserId;
    private $userId;


    public function __construct()
    {
        if (isset($_SESSION['logged_uid'])) {
            $this->loggedInName = $_SESSION['logged_uid'];
            $this->userId = $_SESSION['logged_id'];
            $this->userHash = $_SESSION['logged_hash'];
        }
    }


    public function getLoggedInUserId()
    {
        return array($this->userId,$this->loggedInName,$this->userHash);
    }


    public function tryLogin($username, $password)
    {
        $user = new \Anax\Users\User();
        $user->setDI($this->di);

        $loggedUsers = $user->query()
            ->where("LOWER(acronym) = ?")
            ->execute([strtolower($username)]);

        if (sizeof($loggedUsers) == 0) {
            return false;
        }

        $loggedUser = $loggedUsers[0];
        $result = false;

        if (password_verify($password, $loggedUser->password)) {
            $_SESSION['logged_uid'] = $loggedUser->acronym;
            $_SESSION['logged_id'] = $loggedUser->id;
            $_SESSION['logged_hash'] = $loggedUser->hash;
            $result = true;
        }
        return $result;
    }

    public function isUserLoggedIn()
    {
        return $this->userId;
    }

    public function logout()
    {
        unset($_SESSION['logged_uid']);
        unset($_SESSION['logged_id']);
        unset($_SESSION['logged_hash']);

        $this->loggedInName = null;
        $this->userId = null;
        $this->userHash = null;
    }
}
