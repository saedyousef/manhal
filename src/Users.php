<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT']. 'Database/Database.php';
include dirname(__FILE__) . '/Validations.php';

class Users {

	public $conn;
	public function __construct()
	{
		$this->conn = Database::getConnection();
	}


	/**
	* This action will insert a new record to users table
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param username
	* @param email
	* @param password
	* @param passwordConfirmation
	* @param dateOfBirth
	* @return string status | mixed 
	*/
	public function signup($username, $email, $password, $passwordConfirmation, $dateOfBirth)
	{
		if (isset($_SESSION['user_id'])) {
    		// redirect somewhere	
		}

		$validationsErrors = '';
		$validation = new Validations();
		if(!$validation->email($email))
			$validationsErrors = 'Wrong email format <br>';
		if(!empty($validation->username($username)))
			$validationsErrors .= $validation->username($username);
		if(!empty($validation->password($password, $passwordConfirmation)))
			$validationsErrors .= $validation->password($password, $passwordConfirmation);

		if(!empty($validationsErrors))
			return ['success' => false, 'errors' => $validationsErrors];
		try{
			$statement = $this->conn->prepare('INSERT INTO users (username, email, password, date_of_birth, created)
		    VALUES (:username, :email, :password, :date_of_birth, :created)');

			$statmentExce = $statement->execute([
			    'username' 		=> $username,
			    'email'    		=> $email,
			    'password' 		=> password_hash($password, PASSWORD_DEFAULT),
			    'date_of_birth' => $dateOfBirth,
			    'created' 		=> date('Y-m-d H:i:s'),
			]);

			if($statmentExce)
			{
				$_SESSION['user_id']  = $this->conn->lastInsertId();
				$_SESSION['username'] = $username;
				$_SESSION['email'] 	  = $email;
				return true;
			}
		}
		catch(PDOException $e){
			return ['success' => false, 'errors' => $e->getmessage()];
		}
	}


	public function login($username, $password)
	{

	}
}
