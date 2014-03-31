<?php

App::uses('AppController', 'Controller');

class TagsController extends AppController {
	public $helpers = array('Html', 'Form', 'Js');
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
  			array( // $tags, in the view
					array( // 0-indexed individual items
						'Tag' => array( // Individual "tables" contained in each item
							'Message' => 'There are no tags to display'
						// , 'tag_id' => 1
						)
					)
				)
  		);
  		$this->set('noResults', true);
  	} else { // The user has submitted search criteria

  		set_time_limit(60);


  		$options['joins'] = array(
  		    array('table' => 'users',
  		        'alias' => 'User',
  		        'type' => 'left',
  		        'conditions' => array(
  		            'User.id = Tag.author_id'
  		        )
  		    )
  		);

  		$dates = $this->Tag->formatDates($this->request->data);

			$options['conditions'] = array(
				'Tag.added_at >' => $dates['start'],
				'Tag.added_at <' => $dates['end']
			);

			if ($this->request->data['tagSearch']) {
				$options['conditions']['Label.value'] = $this->request->data['tagSearch'];
			}
			if ($this->request->data['scopeFilter']) {
				$scope = $this->request->data['scopeFilter'];
				switch ($scope) {
					case 'Universal':
						array_push($options['conditions'], '(Label.void IS FALSE OR Label.void IS NULL)');
						break;

					case 'Not Universal':
						array_push($options['conditions'], 'Label.void IS TRUE');
						break;
				}
			}
			if ($this->request->data['originFilter']) {
				$origin = $this->request->data['originFilter'];
				switch ($origin) {
					case 'ArchVision Only':
						$options['conditions']['Content.is_archvision'] = 1;
						break;
					
					case 'Custom Only':
						$options['conditions']['Content.is_archvision'] = 0;
						break;
				}
			}

			$options['fields'] = array(
				'Tag.tag_id',
				'Tag.added_at',
				'Label.void',
				'Label.value',
				'User.name',
				'Content.filename',
				'Content.publish_date'
			);

			// $options['limit'] = 1;
			if ($this->Tag->find('all', $options)) {
				$tags = $this->Tag->find('all', $options);
			} else {
				$tags = array(array('Tag' => array('Message' => 'There are no tags to display')));
				$this->set('noResults', true);
			}
			// $tags = $this->Tag->find('all', $options) ? $this->Tag->find('all', $options) : array(array('Tag' => array('Message' => 'There are no tags to display')));

  		$this->set('tags', $tags);

  		// debug($this->Tag->Content);
  	}
  }
}

?>