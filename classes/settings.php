<?php


Class Settings
{

	public function retrieve_settings($id)
	{
		$DB = new connect_database();
		$sql = "select * from users where user_id = '$id' limit 1";
		$row = $DB->read_1($sql);

		if(is_array($row)){

			return $row[0];
		}
	}

	public function saving_settings($data, $id){

		$DB = new connect_database();

		//It checks if the password length is less than 30 characters using strlen. If so, the password is hashed using SHA-1 and replaced in $data
		$password = $data['password'];
		if(strlen($password) < 30){

			//if the inpuit on the password and confirm password are the same, the system will accept it, if so, it will give an error
			if($data['password'] == $data['password2']){
				$data['password'] = hash("sha1", $password);
			}else{

				unset($data['password']);
			}
		}

		unset($data['password2']);

		//This code constructs an SQL update statement by iterating over the key-value pairs in the $data array and concatenating them into a string with the format 'column_name'='value',. The resulting string contains the full SQL statement needed to update the user's settings in the database.

		$sql = "update users set ";
		foreach ($data as $key => $value) {

		    $sql .= $key . "='" . $value. "',";
		}
		$sql = trim($sql,",");
	
		$sql .= " where user_id = '$id' limit 1";
	
		$DB->save_1($sql);
	}
}