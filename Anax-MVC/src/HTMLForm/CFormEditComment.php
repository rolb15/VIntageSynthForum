<?php
namespace Anax\HTMLForm; class CFormEditComment extends \Mos\HTMLForm\CForm { use \Anax\DI\TInjectionAware, \Anax\MVC\TRedirectHelpers; public function __construct($commentToEdit, $redirect = '') { $this->redirect = $redirect; parent::__construct([], [ 'commentcontent' => [ 'type' => 'textarea', 'label' => 'Comment:', 'required' => true, 'validation' => ['not_empty'], 'value' => $commentToEdit->content, ], 'name' => [ 'type' => 'text', 'label' => 'Name', 'required' => true, 'validation' => ['not_empty'], 'value' => $commentToEdit->name, ], 'email' => [ 'type' => 'text', 'required' => true, 'validation' => ['not_empty', 'email_adress'], 'value' => $commentToEdit->email, ], 'homepage' => [ 'type' => 'text', 'label' => 'Web:', 'validation' => [], 'value' => $commentToEdit->web, ], 'page' => [ 'type' => 'hidden', 'required' => true, 'value' => $commentToEdit->page, ], 'id' => [ 'type' => 'hidden', 'required' => true, 'value' => $commentToEdit->id, ], 'submit' => [ 'type' => 'submit', 'callback' => [$this, 'callbackSubmit'], ], ]); $this->form['legend'] = "Add comment"; } public function check($callIfSuccess = null, $callIfFail = null) { return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']); } public function callbackSubmit() { $now = gmdate('Y-m-d H:i:s'); $users = new \Anax\Comment\Comment(); $users->setDI($this->di); $result = $users->save([ 'id' => $this->Value('id'), 'content' => $this->Value('commentcontent'), 'email' => $this->Value('email'), 'name' => $this->Value('name'), 'page' => $this->Value('page'), 'web' => $this->Value('homepage'), 'created' => $now, 'active' => $now, ]); return $result; } public function callbackSuccess() { $this->di->response->redirect($this->redirect); } public function callbackFail() { $this->AddOutput("<p><i>Something went wrong when processing the form.</i></p>"); $this->redirectTo(); } } 