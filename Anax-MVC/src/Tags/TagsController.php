<?php

namespace Anax\Tags;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class TagsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->tags = new \Anax\Tags\Tags();
        $this->tags->setDI($this->di);
    }


    public function idAction($tagid = null)
    {
        if (!isset($tagid)) {
            die("Missing id");
        }
        $this->theme->setTitle("Tag");

        $sql = 'SELECT name, quest FROM TAGS WHERE id = ' . $tagid;
        $list = $this->db->executeFetchAll($sql);

        if($list[0]->quest !== null) {
            $questarray = explode(",", $list[0]->quest);

            $this->views->add('comment/tagindex', [
                    'content' => $list[0]->name,
            ]);

            for ($i = 0; $i<sizeof($questarray); $i++) {
                $sql = 'SELECT id, name, header, content, created FROM COMMENT WHERE id = ' . $questarray[$i];
                $list = $this->db->executeFetchAll($sql);

                $this->views->add('comment/taglist', [
                    'content' => $list,
                ]);
            }
        } else {
            $this->views->add('comment/nothing', [
                'content' => 'No comments with this tag',
            ]);
        }

    }

}
