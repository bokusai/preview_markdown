<?php
App::uses('AppController', 'Controller');

class AbstractController extends AppController {

	public function beforeFilter(){
		$this->layout = 'my_default';
	}

	protected function _setAjaxResponse($responseData , $statusCode)
	{
		$this->response->statusCode($statusCode);

		$data = ['data' => $responseData];

		$this->set('result' , $data);
		$this->set('_serialize', 'result');
	}
}
