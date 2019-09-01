<?php
class FileDBManager{

	private static $__instance = null;
	private $__fileDBPath = ROOT . '/../FileDB/';

	const CSV_DATA_ARRAY = [
		'PreviewMarkdownDirectory',
	];

	public static function getInstance(){
		if (is_null(self::$__instance)) {
			self::$__instance = new self;
		}
		return self::$__instance;
	}

	private function __getFilePath(string $dataName){
		$filePath = $this->__fileDBPath . $dataName . '.csv';
		if(in_array($filePath, self::CSV_DATA_ARRAY) && !file_exists($filePath)){
			touch($filePath);
		}
		return file_exists($filePath) ? $filePath : false;
	}

	public function getCsvData(string $dataName){
		$filePath = $this->__getFilePath($dataName);
		if(!$filePath){
			debug('not found csvfile');
			return false;
		}

		try {
			$File = new SplFileObject($filePath);
			$File->setFlags(SplFileObject::READ_CSV); 

			$result = [];
			foreach($File as $line){
				if($line[0] === null){
					continue;
				}
				$result[] = $line;
			}
			return $result;
		} catch (Exception $e) {
			debug('SplFileObject error');
			unset($File);
			return false;
		}
	}

	public function addCsvData(string $dataName, array $addData){
		$filePath = $this->__getFilePath($dataName);
		if(!$filePath){
			debug('not found csvfile');
			return false;
		}

		try {
			$currentData = $this->getCsvData($dataName);
			$currentData[] = $addData;
			$newData = $currentData;

			$File = new SplFileObject($filePath, 'w');
			$File->setFlags(SplFileObject::READ_CSV); 

			foreach($newData as $data){
				$File->fputcsv($data);
			}
			return true;
		} catch (Exception $e) {
			debug('SplFileObject error');
			unset($File);
			return false;
		}
	}

	public function updateCsvData(string $dataName, array $updateData, int $lineNumber){
		$filePath = $this->__getFilePath($dataName);
		if(!$filePath){
			debug('not found csvfile');
			return false;
		}

		try {
			$currentData = $this->getCsvData($dataName);
			$currentData[$lineNumber] = $data;
			$newData = $currentData;

			$File = new SplFileObject($filePath, 'w');
			$File->setFlags(SplFileObject::READ_CSV); 

			foreach($newData as $data){
				$File->fputcsv($data);
			}
			return true;
		} catch (Exception $e) {
			debug('SplFileObject error');
			unset($File);
			return false;
		}
	}
}
