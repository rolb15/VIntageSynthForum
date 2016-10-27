<?php
namespace Anax\Setup;

class SetupController implements \Anax\DI\IInjectionAware
{

    use \Anax\DI\TInjectable;

    public function initialize()
    {

    }

    public function usersAction()
    {
        $this->db->dropTableIfExists('user')->execute();
        $this->db->createTable('user', [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
            ])->execute();

        $this->db->insert('user', ['acronym', 'email', 'name', 'password', 'created', 'active']);
        $now = gmdate('Y-m-d H:i:s');

        $this->db->execute(['admin', 'admin@dbwebb.se', 'Administrator', password_hash('admin', PASSWORD_DEFAULT), $now, $now]);
        $this->db->execute(['doe', 'doe@dbwebb.se', 'John/Jane Doe', password_hash('doe', PASSWORD_DEFAULT), $now, $now]);
        $this->db->execute(['gecko', 'seth@gecko.se', 'Seth Gecko', password_hash('gecko', PASSWORD_DEFAULT), $now, $now]);

        $this->views->addString("OK. Reseted DB");
    }

    public function commentsAction()
    {
        $this->db->dropTableIfExists('comment')->execute();

        $this->db->createTable('comment', [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'content' => ['text'],
            'page' => ['varchar(40)', 'not null'],
            'email' => ['varchar(80)'],
            'web' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'], ])->execute();

        $this->db->insert('comment', ['content', 'page', 'email', 'web', 'name', 'created', 'active']);
        $now = gmdate('Y-m-d H:i:s');
        $this->db->execute(['Här är en kommentar!', 'comment1', 'hillary@cia.com', 'http://www.cia.com', 'Hillary', $now, $now]);
        $this->db->execute(['Här är en annan kommentar!', 'comment2', 'donald@trump.com', 'http://www.trump.com', 'Donald', $now, $now]);

        $this->views->addString("OK. Reseted DB");
    }
}
