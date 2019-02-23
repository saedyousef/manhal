<?php

class Validations {
	
	/**
	* This action to validate email format before save it to database
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $email
	* @return bool
	*/
	public function email($email)
	{
		if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))
			return false;

		return true;
	}

	/**
	* This action to validate password before save it to database
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $password
	* @param $passwordConfirmation
	* @return bool| mixed
	*/
	public function password($password, $passwordConfirmation)
	{
		$errors = '';

		if($password == $passwordConfirmation)
		{
			if(strlen($password)  < 8)
				$errors .= 'Password length must be at least 8 characters <br>' ;
			if(!preg_match("#[0-9]+#",$password))
				$errors .= 'Password must contain at least one number <br>';
			if(!preg_match("#[A-Z]+#",$password))
				$errors .= 'Password must contain at least one uppercase <br>' ;
			if(!preg_match("#[a-z]+#",$password))
				$errors .= 'Password must contain at least one lowercase <br>' ;
		}else
			$errors = 'Password and confirm password does\'nt match <br>' ;

		if(empty($errors))
			return null;

		return $errors;
	}

	/**
	* This action to validate username before save it to database
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $username
	* @return bool|mixed
	*/
	public function username($username)
	{
		$errors = null;


		if(strlen($username) < 6)
			return 'Username length must be at least 6 characters <br>';
		
		return $errors;
	}


	/**
	* This action to validate title & description before save it to database
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $title
	* @param $desc
	* @return bool|mixed
	*/
	public function album($title, $desc)
	{
		$errors = '';

		if(strlen($title)  < 4)
			$errors .= 'title length must be at least 4 characters <br>' ;
		if(strlen($desc)  < 20)
			$errors .= 'description length must be at least 20 characters <br>' ;

		if(empty($errors))
			return null;

		return $errors;
	}
}