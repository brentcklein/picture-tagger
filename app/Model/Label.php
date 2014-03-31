<?php

App::uses('AppModel', 'Model');

class Label extends AppModel {
  	public $useTable = "content_tag"; // Should be plural ("content_tags") in order to work with CakePHP out of the box

 //  	public $hasAndBelongsToMany = array(
	// 	'Content' =>
	// 		array(
	// 			'className' => 'Content',
	// 			'joinTable' => 'content_to_tag',
	// 			'foreignKey' => 'tag_id',
	// 			'associationForeignKey' => 'content_id',
	// 			'unique' => false
	// 		)
	// ); 

	public $hasMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'tag_id'
		)
	);
}

?>