<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';
class GoogleComponents {
	
	public function authentication()
	{
		$credentials = dirname(__FILE__) . '/credentials.json';
		$client = new Google_Client();
		$client->setAuthConfig($credentials);
		$client->addScope('https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login');
		$url = $client->createAuthUrl();
		
		if(empty($url))
			return false;
		
		return $url;
	}

	public function getUserInfo($code)
	{
		$credentials = dirname(__FILE__) . '/credentials.json';
		$client = new Google_Client();
		$client->setAuthConfig($credentials);
		$client->addScope('https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login');


		if(empty($code))
		{
		  	$auth_url = $client->createAuthUrl();
		  	return ['authUrl' => $auth_url];
		}
		else 
		{
			$auth = $client->authenticate($code);
		  	$oauth2 = new Google_Service_Oauth2($client);
			$userInfo = $oauth2->userinfo->get()->email;
		  	return ['user_info' => $userInfo, 'authUrl' => false];
		}

		
	}
}