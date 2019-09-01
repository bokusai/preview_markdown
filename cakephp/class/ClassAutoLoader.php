<?php
class ClassAutoLoader {
	private $dirs = [];
	
	public function __construct(){
		spl_autoload_register([$this, 'loader']);
	}
	
	public function registerDir($dir){
		$this->dirs[] = $dir;
	}
	
	public function loader($classname){
		$class_file_path = str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
		foreach ($this->dirs as $dir) {
			$file = $dir . '/' . $class_file_path;
			if(is_readable($file)){
				require $file;
				return;
			}
		}
	}
}
