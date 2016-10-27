<?php
namespace Anax\Comment;

class Comment extends \Anax\MVC\CDatabaseModel
{

    public function getChildren($id)
    {
        $sql = 'SELECT children FROM COMMENT WHERE id =' . $id;

        $children = $this->db->executeFetchAll($sql);

        if($children[0]->children !== null) {
            $childarray = explode(",", $children[0]->children);
        } else {
            $childarray = null;
        }

        return $childarray;
    }

    public function getFilter($content)
    {
        $mdfiltered = $this->textFilter->doFilter($content, 'markdown');

        return $mdfiltered;
    }

    public function presentChild($childarray)
    {
        if($childarray !== null) {
            for ($i = 0; $i<sizeof($childarray); $i++) {

                $sql = 'SELECT id, name, header, hash, level, content, created FROM COMMENT WHERE id = ' . $childarray[$i];
                $answer = $this->db->executeFetchAll($sql);

                $filtered = $this->getFilter($answer[0]->content);

                $childarray2 = $this->getChildren($childarray[$i]);
                $responses = sizeof($childarray2);

                $inset = $answer[0]->level * 25;

                $this->views->add('comment/child', [
                    'answer' => $answer[0],
                    'filtered' => $filtered,
                    'responses' => $responses,
                    'inset' => $inset,
                ]);

                if($childarray2 !== null) {

                    //$this->views->addString('<div class="inset">', 'main');
                    $test = $this->presentChild($childarray2);

                }
            }

            return $responses;
        }
    }
}