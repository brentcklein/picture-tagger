<?php

class Tag extends AppModel {
	public $useTable = 'content_to_tag';

	public $belongsTo = array(
		'Content' => array(
			'className' => 'Content',
			'foreignKey' => 'content_id'
		), 
		'Label' => array(
			'className' => 'Label',
			'foreignKey' => 'tag_id'
		)
	);

	public function formatDates($dates) { //Formats an array containing CakePHP date input to match Tag.created_on
		foreach ($dates as $key => $values) {
			switch ($key) {
				case 'start':
					$dates['start'] = $values['year'] . '-' . $values['month'] . '-' . $values['day'] . ' 00:00:00.000';
					break;

				case 'end':
					$dates['end'] = $values['year'] . '-' . $values['month'] . '-' . $values['day'] . ' 23:59:59.999';
					break;
			}
		}
		return $dates;
	}

}

?>