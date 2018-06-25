<?php 

class User extends Db_object {

	protected static $db_table = "users";
	protected static $db_table_fields = array('username','password','first_name','last_name','user_image');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $user_image;
	
	public $upload_directory = "images_user";
	public $placeholder = "http://placehold.it/400x400&text=image";
	public $tmp_path;
	

	public function image_placeholder_and_path() {
		return empty($this->user_image) ? $this->placeholder : $this->upload_directory . DS . $this->user_image;
	}





	public static function verify_user($username,$password) {
		global $database;
		$username = $database->escape_string($username);
		$password = $database->escape_string($password);

		$sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
		$the_result_array = self::find_by_query($sql);
		return !empty($the_result_array) ? array_shift($the_result_array) : false;

	}

	public function set_file($file) {

		if (empty($file) || !$file || !is_array($file)) {

			$this->custom_errors[] = "There was no file uploaded here";
			return false;

		} else if ($file['error'] != 0) {

			$this->custom_errors[] = $this->upload_errors[$file['error']];
			return false;

		} else {
			$this->user_image = basename($file['name']);
			$this->tmp_path = $file['tmp_name'];
		}
	}

	public function save_user_and_image() {

		

		if(!empty($this->custom_errors)) {
				return false;
		}

		if(empty($this->user_image) || empty($this->tmp_path)) {
				$this->custom_errors[] = "The file was not available";
				return false;
		}

		$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

		if(move_uploaded_file($this->tmp_path, $target_path)) {

			if ($this->save()) {
				unset($this->tmp_path);
				return true;
			}

		} else {

			$this->custom_errors[] = "The file directory probably does not have permission";
			return false;
		}
			

	}


	public function ajax_save_user_image($user_image, $user_id) {

		global $database;

		$user_image = $database->escape_string($user_image);
		$user_id = $database->escape_string($user_id);

		$this->user_image = $user_image;
		$this->id = $user_id;

		$sql = "UPDATE " . self::$db_table . " SET user_image = '{$this->user_image}' WHERE id = {$this->id}";

		$update_image = $database->query($sql);

		echo $this->image_placeholder_and_path();
	}

	public function delete_user_and_photo() {

		if($this->delete()) {
			$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
			
			return unlink($target_path) ? true : false;

		} else{
			return false;
		}
	}



}



 ?>