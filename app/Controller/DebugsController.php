<?php

App::uses('AppController', 'Controller');

class DebugsController extends AppController {

	public $uses = array('Content', 'Tag');

	public function index() {
	}

	public function content() {
		pr($this->Content);
	}

	public function tag() {
		pr($this->Tag);
	}
}

?>