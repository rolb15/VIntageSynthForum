<?php
namespace Anax\Tags;

class Tags extends \Anax\MVC\CDatabaseModel
{
    public function tagExists($tag)
    {
        $this->db->select()
                 ->from("tags")
                 ->where("name = ?")
                 ->execute([$tag]);

        $res = $this->db->fetchAll();

        return count($res) > 0;
    }

    public function getId($tagname)
    {
        $query = "SELECT * FROM tags WHERE name = ?";

        $this->db->select()
                 ->from("tags")
                 ->where("name = ?")
                 ->execute([$tagname]);

        $res = $this->db->fetchAll();

        return $res[0]->id;
    }
}