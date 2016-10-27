<?php
namespace Anax\HTMLForm;

class CFormAddComment extends \Mos\HTMLForm\CForm {

    use \Anax\DI\TInjectionAware, \Anax\MVC\TRedirectHelpers;

    public function __construct($page, $redirect = '')
    {
        $this->redirect = $redirect;

        parent::__construct([], [

            'header' => [
                'type'        => 'text',
                'label'       => 'Header',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'content' => [
                'type' => 'textarea',
                'label' => 'Question:',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'tags' => [
                'type'        => 'text',
                'label'       => 'Tags',
                'required'    => false,
            ],
            'page' => [
                'type' => 'hidden',
                'value' => $page,
            ],
            'submit' => [
                'type' => 'submit',
                'callback' => [$this, 'callbackSubmit'],
            ],
        ]);

        $this->form['legend'] = "Add a question";
    }

    public function check($callIfSuccess = null, $callIfFail = null)
    {
        return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
    }

    public function callbackSubmit()
    {
        $now = gmdate('Y-m-d H:i:s');
        $newtags = "";
        $availableTags = array("service","review","sell","wanted","help","demos","activities");
        $loggedId = $this->di->confirmator->getLoggedInUserId();
        $user = $loggedId[1];
        $userId = $loggedId[0];
        $userHash = $loggedId[2];

        $comment = new \Anax\Comment\Comment();
        $comment->setDI($this->di);

        $result = $comment->save([
            'name'   => $user,
            'header' => $this->Value('header'),
            'content' => $this->Value('content'),
            'poster'   => $userId,
            'hash'   => $userHash,
            'page' => $this->Value('page'),
            'tags' => $this->Value('tags'),
            'created' => $now,
            'active' => $now,
        ]);

        $pid = $this->di->db->lastInsertId();
        $this->newId = $pid;

        $tags = preg_replace('/\s+/', '', $this->Value('tags'));

        $tagsArray = explode(',', $tags);

        if (!empty($tagsArray[0])) {

            for ($i = 0; $i<sizeof($tagsArray); $i++) {

                //$tag = strip_tags($tag);

                $sql = 'SELECT quest FROM TAGS WHERE name = "' . $tagsArray[$i] . '"';
                $a = $this->di->db->executeFetchAll($sql);

                if ($a[0]->quest!==null) {
                    $new = $a[0]->quest . "," . $pid;
                } else {
                    $new = $pid;
                }

                $newArray = explode(",", $new);
                $uses = sizeof($newArray);

                $sql = 'SELECT id FROM TAGS WHERE name = "' . $tagsArray[$i] . '"';
                $b = $this->di->db->executeFetchAll($sql);

                $this->di->db->execute("UPDATE TAGS SET quest = '" . $new . "' WHERE id = " . $b[0]->id);

                $this->di->db->execute("UPDATE TAGS SET uses = " . $uses . " WHERE id = " . $b[0]->id);

                if(in_array($tagsArray[$i], $availableTags)) {
                    $newtags .= "," . $tagsArray[$i];
                }
            }
            $newtags = trim($newtags,",");
            $this->di->db->execute("UPDATE COMMENT SET tags = '" . $newtags . "' WHERE id = " . $pid);
        }

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