<?php
require_once $_SERVER['DOCUMENT_ROOT']. 'Database/Database.php';
include dirname(__FILE__) . '/Validations.php';

/**
* 
*/
class Albums 
{
	public $conn;

	public function __construct()
	{
		$this->conn = Database::getConnection();
	}

	/**
	* This action will return all albums created by user
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $userId
	* @return array|mixed
	*/
	public function getAlbums($userId)
	{
		try {
			$statement = $this->conn->prepare("select * from albums where user_id = :user_id");
			$statement->execute(array(':user_id' => $userId));
			$albums = $statement->fetchAll(\PDO::FETCH_ASSOC);

			if (empty($albums))
				return null;

			return $albums;
			header('Location:index.php');
		} catch (PDOException $e) {
			return ['success' => false, 'errors' => $e->getmessage()];
		}
	}

	/**
	* This action will return all album's images
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $albumId
	* @return array|mixed
	*/
	protected function getAlbumsImages($albumId)
	{
		try {
			$statement = $this->conn->prepare("select * from albums_images where album_id = :album_id");
			$statement->execute(array(':album_id' => $albumId));
			$images = $statement->fetchAll(\PDO::FETCH_ASSOC);

			if (empty($images))
				return null;

			return $images;
		} catch (PDOException $e) {
			return ['success' => false, 'errors' => $e->getmessage()];
		}
	}

	/**
	* This action will return a single album by id
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $albumId
	* @return array|mixed
	*/
	public function alubmDetails($albumId)
	{
		try {
			$statement = $this->conn->prepare("select * from albums where id = :album_id");
			$statement->execute(array(':album_id' => $albumId));
			$images = $statement->fetchAll(\PDO::FETCH_ASSOC);

			if (empty($images))
				return ['success' => false, 'errors' => 'No albums found with this id'];
			$data = [];
			$data['album'] = $images[0];
			$data['images'] = $this->getAlbumsImages($albumId);
			return $data;
		} catch (PDOException $e) {
			return ['success' => false, 'errors' => $e->getmessage()];
		}
	}


	/**
	* This action will create album and upload its images
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $user_id
	* @param $title
	* @param $descreption
	* @param $thumbnail
	* @param $images <Array>
	* @return bool|mixed
	*/
	public function saveAlbum($user_id, $title, $descreption, $thumbnail, $images)
	{
		try{

			$validation = new Validations();

			$errors = $validation->album($title, $descreption);

			if(!empty($errors))
				return ['success' => false, 'errors' => $errors];

			$statement = $this->conn->prepare('INSERT INTO albums (user_id, title, descreption, thumbnail, created)
		    VALUES (:user_id, :title, :descreption, :thumbnail, :created)');

			$statmentExce = $statement->execute([
			    'user_id' 		=> $user_id,
			    'title'    		=> $title,
			    'descreption' 	=> $descreption,
			    'thumbnail' 	=> $thumbnail,
			    'created' 		=> date('Y-m-d H:i:s'),
			]);

		 	$album_id = $this->conn->lastInsertId();
		 	if(!empty($album_id) && !empty($images))
		 	{
		 		$now = date('Y-m-d H:i:s');
		 		$values = [];
			    foreach($images as $value){
			      $_value = "(".$album_id.","."'$value'".",'$now'".")";
			      array_push($values, $_value);
			    }
			    $values_ = implode(",",$values);
			    try {
			    	
				    $sql = "INSERT INTO albums_images(album_id, image_url, created) VALUES" . $values_."";
				    $stmt = $this->conn->prepare($sql);
				    $stmt->execute();
			    } catch (PDOException $e) {
			    	echo $e->getmessage();
			    }
		 	}
		}
		catch(PDOException $e){
			return ['success' => false, 'errors' => $e->getmessage()];
		}
	}

	/**
	* This action will check ig the album exists or not
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $id
	* @return bool
	*/
	private function checkAlbum($id)
	{
		try 
		{
			$statement = $this->conn->prepare("SELECT id from albums where id = :id");
			$statement->execute(array(':id' => $id));
			$album = $statement->fetchAll(\PDO::FETCH_ASSOC);

			if(empty($album))
				return false;

			return true;
		} catch(PDOException $e)
		{
			return false;
		}
	}

	/**
	* This action will check if the image exists or not
	*
	* @author Saed Yousef <saed.alzaben@gmail.com>
	* @param $id
	* @return bool
	*/
	private function checkImage($id)
	{
		try 
		{
			$statement = $this->conn->prepare("SELECT id from albums_images where id = :id");
			$statement->execute(array(':id' => $id));
			$album = $statement->fetchAll(\PDO::FETCH_ASSOC);

			if(empty($album))
				return false;

			return true;
		} catch(PDOException $e)
		{
			return false;
		}
	}


	/**
	* This actil will delete album from database
	*
	* @author Saed Yousef
	* @param $id
	* @return bool
	*/
	public function deleteAlbum($id)
	{
		if(!$this->checkAlbum($id)){
			return false;
		}

		try {
			$statement = $this->conn->prepare("DELETE  from albums where id = :id");
			$statement->execute(array(':id' => $id));
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	/**
	* This actil will delete image from database
	*
	* @author Saed Yousef
	* @param $id
	* @return bool
	*/
	public function deleteImage($id)
	{
		if(!$this->checkImage($id)){
			return false;
		}

		try {
			$statement = $this->conn->prepare("DELETE  from albums_images where id = :id");
			$statement->execute(array(':id' => $id));
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}
}