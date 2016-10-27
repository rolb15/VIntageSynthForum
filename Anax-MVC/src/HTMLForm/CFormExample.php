<?php
 namespace Anax\HTMLForm; class CFormExample extends \Mos\HTMLForm\CForm { use \Anax\DI\TInjectionAware, \Anax\MVC\TRedirectHelpers; public function __construct() { parent::__construct([], [ 'name' => [ 'type' => 'text', 'label' => 'Name of contact person:', 'required' => true, 'validation' => ['not_empty'], ], 'email' => [ 'type' => 'text', 'required' => true, 'validation' => ['not_empty', 'email_adress'], ], 'phone' => [ 'type' => 'text', 'required' => true, 'validation' => ['not_empty', 'numeric'], ], 'submit' => [ 'type' => 'submit', 'callback' => [$this, 'callbackSubmit'], ], 'submit-fail' => [ 'type' => 'submit', 'callback' => [$this, 'callbackSubmitFail'], ], ]); } public function check($callIfSuccess = null, $callIfFail = null) { return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']); } public function callbackSubmit() { $this->AddOutput("<p>DoSubmit(): Form was submitted.<p>"); $this->AddOutput("<p>Do stuff (save to database) and return true (success) or false (failed processing)</p>"); $this->AddOutput("<p><b>Name: " . $this->Value('name') . "</b></p>"); $this->AddOutput("<p><b>Email: " . $this->Value('email') . "</b></p>"); $this->AddOutput("<p><b>Phone: " . $this->Value('phone') . "</b></p>"); $this->saveInSession = true; return true; } public function callbackSubmitFail() { $this->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>"); return false; } public function callbackSuccess() { $this->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>"); $this->redirectTo(); } public function callbackFail() { $this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>"); $this->redirectTo(); } } 