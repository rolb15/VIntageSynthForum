<?php
 namespace Anax\HTMLForm; class FormSmallController { use \Anax\DI\TInjectionAware; public function indexAction() { $this->di->session(); $form = new \Anax\HTMLForm\CFormExample(); $form->setDI($this->di); $form->check(); $this->di->theme->setTitle("Testing CForm with Anax"); $this->di->views->add('default/page', [ 'title' => "Try out a form using CForm", 'content' => $form->getHTML() ]); } } 