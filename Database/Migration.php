<?php

require_once dirname(__FILE__) . '/Database.php';

/**
* Migration class to handle the database tables creatation
*
* @author Saed Yousef <saed.alzaben@gmail.com>
*/
class Migration {
	
	public $conn;
	public function __construct()
	{
		$this->conn = Database::getConnection();
	}

	/**
	* This action will create users table if it is not exists
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @return string message
	*/
	protected function createUsersTable()
	{

		$sql = "CREATE TABLE IF NOT EXISTS users(
			id int(11) primary key auto_increment,
			email varchar(255),
			username varchar(255),
			password varchar(255),
			date_of_birth date,
			created datetime,
			UNIQUE (email),
			UNIQUE (username)
		)ENGINE=InnoDB CHARACTER SET=utf8";

		if($this->conn->exec($sql))
			return 'users table created successfully';
		else
			return 'users table does not created or already exists!';
	}

	/**
	* This action will create albums table if it is not exists
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @return string message
	*/
	protected function createAlbumsTable()
	{
		$sql = "CREATE TABLE IF NOT EXISTS albums(
			id int(11) primary key auto_increment,
			user_id int(11),
			title varchar(255),
			descreption text,
			thumbnail varchar(500),
			created datetime
		)ENGINE=InnoDB CHARACTER SET=utf8";

		if($this->conn->exec($sql))
			return 'albums table created successfully';
		else
			return 'albums table does not created or already exists!';
	}

	/**
	* This action will create albums_images table if it is not exists
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @return string message
	*/
	protected function createImagesTable()
	{
		$sql = "CREATE TABLE IF NOT EXISTS albums_images(
			id int(11) primary key auto_increment,
			album_id int(11),
			image_url varchar(500),
			created datetime
		)ENGINE=InnoDB CHARACTER SET=utf8";

		if($this->conn->exec($sql))
			return 'albums_images table created successfully';
		else
			return 'albums_images table does not created or already exists!';
	}

	/**
	* This action will initialize the tables
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @return array
	*/
	public function initialize()
	{
		return [
			'users'  		=> $this->createUsersTable(),
			'albums' 		=> $this->createAlbumsTable(),
			'albums_images' => $this->createImagesTable()
		];
	}
}