
<?php

App::uses('AppController', 'Controller');

class LabelsController extends AppController {
	public $helpers = array('Html', 'Form', 'Js');

	public function index() {

	}

	public function edit($id=null) {
		// $this->render = false;
		// $this->layout = false;
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			// $obj = $this->Label->findById($id);
			if ($this->Label->save($this->request->data)) {
				$this->Label->recursive = -1;
				$res = array(
					'object' => $this->Label->findById($id, 'Label.void'),
					'id' => $id
				);
				return json_encode($res);
			}
			// return var_export($this->request->data, true);
			// return json_encode(array('id' => $id, 'object' => $this->request->data));
		}
	}
}

?>