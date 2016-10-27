<?php

namespace Anax\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);
        $this->form = new \Mos\HTMLForm\CForm();
    }

    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($page = null, $redirect = null)
    {

        $page = empty($page) ? $this->request->getRoute() : $page;
        $redirect = empty($redirect) ? $page : $redirect;

        $all = $this->comments->query()
            ->where("page = '$page'")
            ->execute();

        $this->views->add('comment/commentsDB', [
            'comments' => $all,
            'page'     => $page,
        ]);
    }

    /**
     * New Question.
     *
     * @return void
     */
    public function newAction($page = null, $redirect = null)
    {

        $page = empty($page) ? $this->request->getRoute() : $page;
        $redirect = empty($redirect) ? $page : $redirect;

        if ($this->confirmator->isUserLoggedIn()) {

            $form = new \Anax\HTMLForm\CFormAddComment($page, $redirect);
            $form->setDI($this->di);
            $form->check();

            $this->views->add('default/page', [
                    'title' => "New question",
                    'content' => $form->getHTML()
                ]);

        } else {

            $this->views->add('default/loginneeded');

        }
    }

    /**
     * New Reply.
     *
     * @return void
     */
    public function replyAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        if ($this->confirmator->isUserLoggedIn()) {

            $form = new \Anax\HTMLForm\CFormAddReply($id);
            $form->setDI($this->di);
            $form->check();

            $question = $this->comments->find($id);

            $filtered = $this->comments->getFilter($question->content);

            $sql = 'SELECT id FROM COMMENT WHERE page = "question" AND header = "' . $question->header . '"';
            $root = $this->di->db->executeFetchAll($sql);

            $this->views->add('comment/parent', [
                'question' => $question,
                'filtered' => $filtered,
                'root' => $root,
            ]);

            $this->views->add('comment/reply', [
                    'title' => "Reply",
                    'content' => $form->getHTML()
                ]);

        } else {

            $this->views->add('default/loginneeded');

        }
    }

    /**
     * View latest comments.
     *
     * @return void
     */
    public function lastAction($page = null, $redirect = null)
    {
        $page = empty($page) ? $this->request->getRoute() : $page;
        $redirect = empty($redirect) ? $page : $redirect;

        $all = $this->comments->query()
            ->where("page = '$page'")
            ->execute();

        $this->views->add('comment/last', [
            'comments' => $all,
            'page'     => $page,
        ]);

    }

    public function idAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $this->theme->setTitle("Question");

        $question = $this->comments->find($id);

        $filtered = $this->comments->getFilter($question->content);

        $sql = 'SELECT id FROM COMMENT WHERE page = "question" AND header = "' . $question->header . '"';
        $root = $this->di->db->executeFetchAll($sql);

        $childarray = $this->comments->getChildren($id);
        $responses = sizeof($childarray);

        $tag_array = explode(",",$question->tags);

        $this->views->add('comment/view', [
            'question' => $question,
            'filtered' => $filtered,
            'responses' => $responses,
            'tags' => $tag_array,
            'root' => $root,
        ]);

        $resp = $this->comments->presentChild($childarray);
    }



    /**
     * Edit comments.
     *
     * @return void
     */
    public function editAction($id, $redirect = '') {
        $comment = $this->comments->find($id);
        $redirect = empty($redirect) ? $comment->page : $redirect;

        $form = new \Anax\HTMLForm\CFormEditComment($comment, $redirect);
        $form->setDI($this->di);
        $form->check();

        $this->views->add('default/page', [
            'title' => "",
            'content' => $form->getHTML()
        ]);
    }

    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction()
    {
        $isPosted = $this->request->getPost('doCreate');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
        ];

        $comments = new Anax\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $comments->add($comment);

        $this->response->redirect($this->request->getPost('redirect'));
    }

    /**
     * Delete single comment.
     *
     * @return void
     */
    public function deleteAction($id, $redirect = '') {

        if (!isset($id)) {
            die();
        }
        $comment = $this->comments->find($id);
        $redirect = empty($redirect) ? $comment->page : $redirect;

        $res = $this->comments->delete($id);
        $this->response->redirect($redirect);
    }

    /**
     * Remove all comments.
     *
     * @return void
     */
    public function removeAllAction($page = null)
    {
        $this->comments->deletePage($page);

        $url = $this->url->create('');

        $this->response->redirect($url);
    }
}
