<?php
namespace Anax\HTMLForm;

class CFormAddReply extends \Mos\HTMLForm\CForm {

    use \Anax\DI\TInjectionAware, \Anax\MVC\TRedirectHelpers;

    public function __construct($id)
    {
        $this->redirect = 'comment/id/' . $id;
        $this->id = $id;

        parent::__construct([], [

            'content' => [
                'type' => 'textarea',
                'label' => 'Comment:',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'page' => [
                'type' => 'hidden',
                'value' => 'comment',
            ],
            'submit' => [
                'type' => 'submit',
                'callback' => [$this, 'callbackSubmit'],
            ],
        ]);

        $this->form['legend'] = "Reply";
    }

    public function check($callIfSuccess = null, $callIfFail = null)
    {
        return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
    }

    public function callbackSubmit()
    {
        $now = gmdate('Y-m-d H:i:s');
        $loggedId = $this->di->confirmator->getLoggedInUserId();
        $user = $loggedId[1];
        $userId = $loggedId[0];
        $userHash = $loggedId[2];

        $comment = new \Anax\Comment\Comment();
        $comment->setDI($this->di);

        $sql = 'SELECT header, level FROM COMMENT WHERE id = ' . $this->id;
        $subject = $this->di->db->executeFetchAll($sql);

        $newLevel = $subject[0]->level + 1;

        $result = $comment->save([
            'name'   => $user,
            'header' => $subject[0]->header,
            'content' => $this->Value('content'),
            'poster'   => $userId,
            'parent' => $this->id,
            'level' => $newLevel,
            'hash'   => $userHash,
            'page' => $this->Value('page'),
            'created' => $now,
            'active' => $now,
        ]);

        $pid = $this->di->db->lastInsertId();

        $sql = 'SELECT children FROM COMMENT WHERE id = ' . $this->id;
        $old = $this->di->db->executeFetchAll($sql);

        if ($old[0]->children!==null) {
            $new = $old[0]->children . "," . $pid;
        } else {
            $new = $pid;
        }

        $this->di->db->execute("UPDATE COMMENT SET children = '" . $new . "' WHERE id = " . $this->id);

        return $result;
    }

    public function callbackSuccess()
    {
        $this->di->response->redirect($this->redirect);
    }

    public function callbackFail()
    {
        $this->AddOutput("<p><i>Something went wrong when processing the form.</i></p>");
        $this->redirectTo();
    }
}