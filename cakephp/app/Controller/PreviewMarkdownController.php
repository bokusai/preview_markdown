<?php
App::uses('AbstractController', 'Controller');

class PreviewMarkdownController extends AbstractController{

	public function index(){
		debug(FileDBManager::getInstance()->addCsvData('markdownPreviewDirectory', ['testtesttest', 'ddd']));
		$data = FileDBManager::getInstance()->getCsvData('markdownPreviewDirectory');
		debug($data);
	}

	public function getMarkdownData(){
		$this->viewClass = 'Json';
		if(!$this->request->is('ajax')){
			return $this->_setAjaxResponse(false, 400);
		}

		$file_path = __DIR__ . '/../../../../../test0828/clinic_test.md';
		$markdownContent = file_get_contents($file_path);
		$parsedData = $markdownContent;

		$this->_setAjaxResponse(['markdownData' => $parsedData], 200);
	}

	public function setDirectoryPath(){
		$this->viewClass = 'Json';
		if(!$this->request->is('ajax') && !empty($this->request->data('directoryPath'))){
			return $this->_setAjaxResponse('false', 400);
		}

		$addData = [$this->request->data('directoryPath')];
		FileDBManager::getInstance()->addCsvData('markdownPreviewDirectory', $addData);

		$this->_setAjaxResponse(['success' => true], 200);
	}
}
