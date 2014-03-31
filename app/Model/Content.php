<?php

App::uses('AppModel', 'Model');

class Content extends AppModel {
	public $useTable = "content";
	public $name = "Content";

	// public $hasAndBelongsToMany = array(
	// 	'Tag' =>
	// 		array(
	// 			'className' => 'Tag',
	// 			'joinTable' => 'content_to_tag',
	// 			'foreignKey' => 'content_id',
	// 			'associationForeignKey' => 'tag_id',
	// 			'unique' => false,
	// 			'conditions' => '',
	// 			'fields' => '',
	// 			'order' => '',
	// 			'limit' => '',
	// 			'offset' => '',
	// 			'finderQuery' => '',
	// 			'with' => ''
	// 		)
	// );

	public $hasMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'content_id'
		)
	);
}

?>