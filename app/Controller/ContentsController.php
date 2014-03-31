<?php

class ContentsController extends AppController {
	public $helpers = array('Html', 'Form');
	public $uses = array('Content', 'Tag');

	public function debug() {
		if ($this->request->is('post')) {
			pr($this->request->data);
		}
	}

  public function index() {
  	if (!$this->request->is('post')) { // The user has just navigated to the page for the first time
  		$this->set(
  			'tags', 
  			array(
					array(
						'Tag' => array(
							'Message' => 'There are no tags to display'
						)
					)
				)
  		);
  	} else { // The user has submitted search criteria
  		// $start = $this->request->data['start'];
  		// $end = $this->request->data['end'];
  		$this->set(
  			'tags',
  			$this->Tag->find(
  				'all' 
  			, array(
  					// 'conditions' => array(
  					// 	'Tag.created_on >' => $start,
  					// 	'Tag.created_on <' => $end
  					// )
  					'limit' => 5
  				)
  			)
  		);
  	}
  }
}

?>