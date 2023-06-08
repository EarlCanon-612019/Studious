<?php

class Login
{

	private $error = "";

	public function evaluate($data)
	{
		//adds slashes before special characters so that system will read the inputs easier. Also secures security so that incase hackers are trying to put malicious softwares using malicious characters in the system, you can prevent it
		$email = addslashes($data['email']);
		$password = addslashes($data['password']);

		// "limit 1" = limits to 1 row. Instead of checking both password and email in the query, passwords ands email are seperated to avoid sql attack
		$query = "select * from users where email = '$email' limit 1 ";

		
		$DB = new connect_database();
		$result = $DB->read_1($query);
 
		if($result)
		{

			$row = $result[0];
			//checks if the password is correct or else the system will give an error output
			if($this->pass_hash($password) == $row['password'])
			{

				//create session data to authecticate the user
				//Using session, we can move information between pages of the same website
				//Session is a good place to keep information for a logged in user
				//Session ensures that users are always logged in throughout the website
				$_SESSION['studious_user_id'] = $row['user_id'];

			}else {

				$this->error .= " ---Wrong Password or Email. Please try again--- <br>";
			}
		
		}else {

			$this->error .= " ---Wrong Password or Email. Please try again---  <br>";
		}

		return $this->error;
	}	


	//a function that uses one way encryption that hashes the users password
	private function pass_hash($text){

		$text = hash("sha1", $text);    
		return $text;
	}

	//function that checks user log-ins
	public function log_check($id_log)
	{
			if (is_numeric($id_log))
			{

			$query = "select * from users where user_id = '$id_log' limit 1 ";

			
			$DB = new connect_database();
			$result = $DB->read_1($query);

			if($result)
			{
				$user_info = $result[0];
			  	return $user_info;
			}else
			{
				// Redirect to the login page
				header("Location: login.php");
				die;
			}


	    
		}else
		{
			header("Location: login.php");
			die;
		}

	}
}

