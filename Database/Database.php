<?php
include_once $_SERVER['DOCUMENT_ROOT']. 'Constants/Credentials.php';

class Database {
	
	protected static $link;

	/**
	* Private constructor to prevent instantiation
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	*/
	private function __construct(){

	}

	/**
	* This action will establish the connection with the database
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @return PDO object
	*/
	public static function connect()
	{
		if(!self::$link)
		{
			$host = Credentials::HOSTNAME;
			$db = Credentials::DATABASE;

			try{
				$conn = new PDO("mysql:host=$host;dbname=$db", Credentials::USERNAME, Credentials::PASSWORD);
		    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    		self::$link = $conn;
			 }catch(PDOException $e){
			    echo $e->getmessage();exit();
			 }
		}

		return self::$link;
	}

	/**
	* This action will return the PDO object
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @return PDO object
	*/
	public static function getConnection()
	{
		if(!self::$link)
			self::connect();

		return self::$link;
	}
}