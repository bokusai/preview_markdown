<?php
App::uses('AbstractController', 'Controller');

class PreviewMarkdownController extends AbstractController{

	private function __getMarkdownContentArray($directory){
		$PreviewMarkdownDirectoryArray = FileDBManager::getInstance()->getCsvData('PreviewMarkdownDirectory');
		foreach($PreviewMarkdownDirectoryArray as $PreviewMarkdownDirectory){
			$tmp = array_values($PreviewMarkdownDirectory);
			if($directory == array_shift($tmp)){
				$filePathArray = [];
				$dir = opendir(ROOT . '/../../' . $directory . '/');
				$i = 0;
				while(($fileName = readdir($dir)) !== false){
					if(strpos($fileName, '.md')){
						$filePathArray[] = [
							'fileName' => $fileName,
							'filePath' => ROOT . '/../../' . $directory . '/' . $fileName
						];
					}
					if($i > 100){ break; }else{ $i++; }
				}
				closedir($dir);
			}
		}

		$markdownContentArray = [];
		foreach($filePathArray as $filePath){
			$markdownContentArray[] = [
				'fileName' => $filePath['fileName'],
				'filePath' => file_get_contents($filePath['filePath'])
			];
		}
		return $markdownContentArray;
	}

	public function index(){
		$this->set('directoryArray', $directoryArray = FileDBManager::getInstance()->getCsvData('PreviewMarkdownDirectory'));
	}

	public function preview(){
		if(empty($this->request->params['directory'])){
			return;
			//return $this->redirect(['controller' => 'PreviewMarkdown', 'action' => 'index']);
		}

		$this->set('directory', $this->request->params['directory']);
		$contentArray = $this->__getMarkdownContentArray($this->request->params['directory']);
		$this->set('contentArray', $contentArray);
	}

	public function getMarkdownData(){
		$this->viewClass = 'Json';
		if(!$this->request->is('ajax') && !empty($this->request->data('directory')) && !empty($this->request->data('fileName'))){
			return $this->_setAjaxResponse(false, 400);
		}

		$filePath = ROOT . '/../../' . $this->request->data('directory') . '/' . $this->request->data('fileName');
		if(!file_exists($filePath)){
			return $this->_setAjaxResponse(false, 404);
		}

		$fileUpdateTime = filemtime($filePath);
		if($fileUpdateTime === $this->Session->read($filePath . 'updateTime')){
			return $this->_setAjaxResponse(['update' => time()], 200);
		}
		$this->Session->write($filePath . 'updateTime', $fileUpdateTime);

		$markdownContent = file_get_contents($filePath);
		$parsedData = $markdownContent;

		return $this->_setAjaxResponse(['markdownData' => $parsedData, 'update' => time()], 200);
	}

	public function setDirectoryPath(){
		$this->viewClass = 'Json';
		if(!$this->request->is('ajax') && !empty($this->request->data('directory'))){
			return $this->_setAjaxResponse('false', 400);
		}

		if(!file_exists(ROOT . '/../../' . $this->request->data('directory') . '/')){
			return $this->_setAjaxResponse(ROOT . '/../../' . $this->request->data('directory') . '/', 404);
		}

		$addData = [$this->request->data('directory')];
		FileDBManager::getInstance()->addCsvData('PreviewMarkdownDirectory', $addData);

		$this->_setAjaxResponse(['success' => true], 200);
	}
}
