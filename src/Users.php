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
		

		$validationsErrors = '';

		if(!$this->checkEmail($email))
			$validationsErrors .= 'Email already exists <br>';

		if(!$this->checkUsername($username))
			$validationsErrors .= 'Username already exists <br>';

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

			$_SESSION['user_id']  = $this->conn->lastInsertId();

			header('Location:index.php');
		}
		catch(PDOException $e){
			return ['success' => false, 'errors' => $e->getmessage()];
		}
	}

	/**
	* This action will log the user in and starts a session for him
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $username
	* @param $password
	* @return redirect|mixed
	*/
	public function login($username, $password)
	{
		try {
			$statement = $this->conn->prepare("select * from users where username = :username limit 1");
			$statement->execute(array(':username' => strtolower($username)));
			$userObject = $statement->fetch();

			if(empty($userObject))
				return ['success' => false, 'errors' => 'Incorrect username'];

			if(!password_verify($password, $userObject['password']))
				return ['success' => false, 'errors' => 'Inccorect password'];

			$_SESSION['user_id']  = $userObject['id'];

			header('Location:index.php');
		} catch (PDOException $e) {
			return ['success' => false, 'errors' => $e->getmessage()];
		}
	}

	/**
	* This action will check if the email already exists or not
	* 
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $email
	* @return bool
	*/
	protected function checkEmail($email)
	{
		try {
			$statement = $this->conn->prepare("select * from users where email = :email limit 1");
			$statement->execute(array(':email' => strtolower($email)));
			$userObject = $statement->fetch();

			if(!empty($userObject))
				return false;

			return true;

		} catch (PDOException $e) {
			return ['success' => false, 'errors' => $e->getmessage()];
		}
	}

	/**
	* This action will check if the username already exists or not
	* 
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $username
	* @return bool
	*/
	protected function checkUsername($username)
	{
		try {
			$statement = $this->conn->prepare("select * from users where username = :username limit 1");
			$statement->execute(array(':username' => strtolower($username)));
			$userObject = $statement->fetch();

			if(!empty($userObject))
				return false;

			return true;

		} catch (PDOException $e) {
			return ['success' => false, 'errors' => $e->getmessage()];
		}
	}

	/**
	* This action will log user in with google account
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $email
	* @return redirect
	*/
	public function googleLogin($email)
	{
		$statement = $this->conn->prepare("select * from users where email = :email limit 1");
		$statement->execute(array(':email' => strtolower($email)));
		$userObject = $statement->fetch();
		if(empty($userObject))
		{
			$registerUser = $this->googleRegister($email);
			if(!$registerUser)
				header("Location:index.php?glfailed");

			$_SESSION['user_id']  = $registerUser;

			header("Location:index.php");
		}
		$_SESSION['user_id']  = $userObject['id'];
		header("Location:index.php");
	}

	/**
	* This action will create new record in users table
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $email
	* @return userId
	*/
	private function googleRegister($email)
	{
		try {
			$statement = $this->conn->prepare('INSERT INTO users (username, email, created)
		    VALUES (:username, :email, :created)');

			$statmentExce = $statement->execute([
			    'username' 		=> $email,
			    'email'    		=> $email,
			    'created' 		=> date('Y-m-d H:i:s'),
			]);

			return $this->conn->lastInsertId();
		} catch (Exception $e) {
			return false;
		}
	}
}
