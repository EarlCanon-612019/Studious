<?php

class Signup
{
	private $error = "";

	public function evaluate($data)
	{

		foreach ($data as $key => $value) {

			// if input is empty, shows an error
			if(empty($value))
			{
				$this->error = $this->error . $key . " is empty!<br>";
			}


			if($key == "email")
			{
				//regular expression
				//shows an error if email is incorrect
				if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {

					$this->error = $this->error ."Invalid email address. Please try again <br>";
				}			
			}

			if($key == "first_name")
			{
				//shows an error if user puts a numerical input or the input has a space
				if(is_numeric($value)) {

					$this->error = $this->error ."ERROR! First name must not consist of a number!<br>";
				}

				//shows an error if users input has a space
				if(strstr($value, " ")) {

					$this->error = $this->error ."ERROR! First name can't have spaces!<br>";
				}
				
				
			}

			if($key == "last_name")
			{
				//shows an error if user puts a numerical input 
				if(is_numeric($value)) {

					$this->error = $this->error ."ERROR! Last name must not consist of a number!<br>";
				}

				//shows an error if users input has a space
				if(strstr($value, " ")) {

					$this->error = $this->error ."ERROR! Last name can't have spaces!<br>";
				}
				
				
			}


		}

		if($this->error == "")
		{

			//no error
			$this-> user_create($data);
		}else
		{
			//once an error occured, system will return the error variable
			return $this->error;
		}
	}

	public function user_create($data)
	{
		//ucfirst is a function that makes teh starting letter of the input a capital letter
		$first_name = ucfirst($data['first_name']);
		$last_name =ucfirst($data['last_name']);
		$gender = $data['gender'];
		$email = $data['email'];
		$password = $data['password'];

		$password = hash("sha1", $password);

		//create these
        $url_address = strtoLower($first_name) . "." . strtoLower($last_name);
    	$user_id = $this->create_userid();


		$query = "insert into users 
		(user_id, first_name, last_name, gender, email, password, url_address)
		 values ('$user_id', '$first_name', '$last_name', '$gender', '$email', '$password', '$url_address')";

		
		$DB = new connect_database();
		$DB->save_1($query);

	}	


	private function create_userid()
	{
		//system generates a random number from 4 - 19 as user id
		$length = rand(4, 19);
		$number = "";

		//loops 10 times
		for ($i=0; $i < $length; $i++) { 
			// code...
			$new_rand = rand(0,9);

			$number = $number . $new_rand;

		}

		return $number;
	}
}