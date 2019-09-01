<?php
class FileDB_DAOManager {
	private static $__DAOArray = [];
	private static $__classNamePrefix = 'FileDB_DataTable_';

	private function __construct() {
	}

	public static function getInstance($className)
	{
		$className = strpos($className, self::$__classNamePrefix) === 0 ? $className : (self::$__classNamePrefix . $className);
		if (!isset(self::$__DAOArray[$className])) {
			if(!class_exists($className)) {
				throw new DomainException($className . 'は存在しないクラスです');
			}
			self::$__DAOArray[$className] = new $className;
		}
		return self::$__DAOArray[$className];
	}
}
