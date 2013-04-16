<?php

class AbstractModel
{	
	static protected $database;
	
	
	/**
	 * pripojeni k databazi
	 */
	public static function connect($options)
	{	
		if (!self::$database) {
			self::$database = new PDO('mysql:host=' . $options['host'] . ';dbname=' . $options['dbname'] . '', $options['username'], $options['password']);
			self::$database->exec('SET CHARACTER SET ' . $options['charset']);
		}
		return self::$database;			
	}	

	/**
	 * nastaveni modu pro vypis chyb a upozorneni
	 * @param boolean $value
	 */
	public static function setDebug($value)
	{
		if ($value === true) {
			self::$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		}	
	}

	
}