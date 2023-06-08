<?php

class Publish
{
	private $error = "";

	public function publish_post($user_id, $data, $files)
	{
		if(!empty($data['post']) || !empty($files['file']['name']) || isset($data['user_profile_img']) || isset($data['user_cover_img']))
		{

			$user_image = "";
			$photo_image = 0;
			$user_profile_img = 0;
			$user_cover_img = 0;

			if(isset($data['user_profile_img']) || isset($data['user_cover_img']))
			{

				$user_image = $files;
				$photo_image = 1;

				if(isset($data['user_cover_img']))
				{
					
					$user_cover_img = 1;
				}

				if(isset($data['user_profile_img']))
				{
					
					$user_profile_img = 1;
				}
				
			}else
			{
	
				if(!empty($files['file']['name']))
				{

						$new_folder = "uploads/" . $user_id . "/";

							//create folder for users
							if(!file_exists($new_folder))
							{
								//7777 file permission means that everyone regardless of who is accessing the system has access to read, write, and execute
								mkdir($new_folder, 0777, true);
								//adds an empty index.php file to avoid hackers from browsing directories through the url
								file_put_contents($new_folder . "index.php", "");
							}

							$class_image = new Image();

							$user_image = $new_folder . $class_image->create_filename(15) . ".jpg";
							move_uploaded_file($_FILES['file']['tmp_name'], $user_image);

							$class_image->image_resize($user_image, $user_image, 1500, 1500);

							
						$photo_image = 1;
					}
			}

			$post = "";
			if(isset($data['post']))
			{
				$post = addslashes($data['post']);
			}
			
			$post_id = $this->create_postid();
			$parent = 0;
			$DB = new connect_database();

			if(isset($data['parent']) && is_numeric($data['parent'])){

				$parent = $data['parent'];

				$sql = "update posts set comments = comments + 1 where post_id = '$parent' limit 1";
				$DB->save_1($sql);
			}
			$query = "insert into posts (user_id, post_id, post, image, photo_image, user_profile_img, user_cover_img, parent) values ('$user_id', '$post_id', '$post', '$user_image', '$photo_image', '$user_profile_img', '$user_cover_img','$parent')";

			$DB->save_1($query);
			
		}else
		{

			$this->error .= "Please type something to publish! <br>";
		}

		return $this->error; 

	}

	public function edit_post($data, $files)
	{
		if(!empty($data['post']) || !empty($files['file']['name']))
		{

			$user_image = "";
			$photo_image = 0;
				
				if(!empty($files['file']['name']))
				{

						$new_folder = "uploads/" . $user_id . "/";

							//create folder for users
							if(!file_exists($new_folder))
							{
								//7777 file permission means that everyone regardless of who is accessing the system has access to read, write, and execute
								mkdir($new_folder, 0777, true);
								//adds an empty index.php file to avoid hackers from browsing directories through the url
								file_put_contents($new_folder . "index.php", "");
							}

							$class_image = new Image();

							$user_image = $new_folder . $class_image->create_filename(15) . ".jpg";
							move_uploaded_file($_FILES['file']['tmp_name'], $user_image);

							$class_image->image_resize($user_image, $user_image, 1500, 1500);

							
						$photo_image = 1;
					}
			

			$post = "";
			if(isset($data['post']))
			{
				$post = addslashes($data['post']);
			}
			
			$post_id = addslashes($data['post_id']);

			if($photo_image){
				$query = "update posts set post = '$post', image = '$user_image' where post_id = '$post_id' limit 1";
			}else{
				$query = "update posts set post = '$post' where post_id = '$post_id' limit 1";
			}

			$DB = new connect_database();
			$DB->save_1($query);
			
		}else
		{

			$this->error .= "Please type something to publish! <br>";
		}

		return $this->error; 

	}

	public function retrieve_post($id_log)
	{
		//a function that displays post in a descending order so that recepnt posts will be displayed first
		$query = "select * from posts where parent = 0 and user_id = '$id_log' order by id desc limit 10";

		$DB = new connect_database();
		$result = $DB->read_1($query);

		if($result)
		{
			return $result;
		}else
		{
			return false;
		}
	}

	public function retrieve_comments($id_log)
	{
		//a function that displays post in a descending order so that recepnt posts will be displayed first
		$query = "select * from posts where parent = '$id_log' order by id asc limit 10";

		$DB = new connect_database();
		$result = $DB->read_1($query);

		if($result)
		{
			return $result;
		}else
		{
			return false;
		}
	}


	public function retrieve_single_post($post_id)
	{

		if(!is_numeric($post_id)){

			return false;
		}

		$query = "select * from posts where post_id = '$post_id' limit 1";

		$DB = new connect_database();
		$result = $DB->read_1($query);

		if($result)
		{
			return $result[0];
		}else
		{
			return false;
		}
	}

	public function delete_post($post_id)
	{


		if(!is_numeric($post_id)){

			return false;
		}

		$DB = new connect_database();
		$sql = "select parent from posts where post_id = '$post_id' limit 1";
		$result = $DB->read_1($sql);


		if(is_array($result)){

			if($result[0]['parent'] > 0){

					$parent = $result[0]['parent'];

					$sql = "update posts set comments = comments - 1 where post_id = '$parent' limit 1";
					$DB->save_1($sql);
				}
		}
			

		$query = "delete from posts where post_id = '$post_id' limit 1";

		
		$DB->save_1($query);
	}

	//a function that checks if the user_id matches with the user_id that post's the particular content
	public function my_personal_post ($post_id, $studious_user_id)
		{

					
			if(!is_numeric($post_id)){

				return false;
			}

			$query = "select * from posts where post_id = '$post_id' limit 1";

			$DB = new connect_database();
			$result = $DB->read_1($query);

			if(is_array($result)){

				if($result[0]['user_id'] == $studious_user_id){

					return true;
				}
			}

			return false;
		}

	public function get_reacts($id, $type){

		$DB = new connect_database();
		$type = addslashes($type);

		if(is_numeric($id)){

			//get reacts details
			$sql = "select reacts from reacts where type='$type' && content_id = '$id' limit 1";
			$result = $DB->read_1($sql);
			if(is_array($result)){

				$reacts = json_decode($result[0]['reacts'], true);
				return $reacts;
			}
		}

		return false;
	}

	public function react_post($id, $type, $studious_user_id){


			$DB = new connect_database();

			//save reacts information
			$sql = "select reacts from reacts where type='$type' && content_id = '$id' limit 1";
			$result = $DB->read_1($sql);
			if(is_array($result)){

				$reacts = json_decode($result[0]['reacts'], true);

				$user_ids = array_column($reacts, "user_id");

				if(!in_array($studious_user_id, $user_ids)){

					$arr["user_id"] = $studious_user_id;
					$arr["date"] = date("Y-m-d H:i:s");

					$reacts[] = $arr;
					// javascript object notation -  converts array into a string
					$reacts_string = json_encode($reacts);
					$sql = "update reacts set reacts = '$reacts_string' where type='$type' && content_id = '$id' limit 1";
					$DB->save_1($sql);

					//increment the right table
					$sql = "update {$type}s set reacts = reacts + 1 where {$type}_id = '$id' limit 1";
					$DB->save_1($sql);

				}else{

					//removes a memory location (removes react value if clicked twice by the same user)
					$memory_key = array_search($studious_user_id, $user_ids);
					unset($reacts[$memory_key]);

					$reacts_string = json_encode($reacts);
					$sql = "update reacts set reacts = '$reacts_string' where type='$type' && content_id = '$id' limit 1";
					$DB->save_1($sql);

						//decrement the posts table
					$sql = "update {$type}s set reacts = reacts - 1 where {$type}_id = '$id' limit 1";
					$DB->save_1($sql);
				}
				

			}else{

				$arr["user_id"] = $studious_user_id;
				$arr["date"] = date("Y-m-d H:i:s");

				$arr2[] = $arr;

				// javascript object notation -  converts array into a string
				$reacts = json_encode($arr2);
				$sql = "insert into reacts (type, content_id, reacts) values ('$type', '$id', '$reacts')";
				$DB->save_1($sql);

				//increment the right table
				$sql = "update {$type}s set reacts = reacts + 1 where {$type}_id = '$id' limit 1";
				$DB->save_1($sql);
			}
		

	}
	private function create_postid()
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