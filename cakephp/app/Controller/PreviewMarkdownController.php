<?php
App::uses('AppController', 'Controller');

class PreviewMarkdownController extends AppController {

	public function index(){
	}

	public function getMarkdownData(){
		$this->viewClass = 'Json';
		if(!$this->request->is('ajax')) {
			return $this->_setAjaxResponse(false, 400);
		}
		$data = $this->request->data;

		$file_path = __DIR__ . '/../../../../../test0828/clinic_test.md';
		$markdownContent = file_get_contents($file_path);

		$parsedData = $markdownContent;
		$this->_setAjaxResponse(['markdownData' => $parsedData], 200);
	}
}
