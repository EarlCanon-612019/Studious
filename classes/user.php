<?php

class User
{

	public function retrieve_data($id_log)
	{

		$query = "select * from users where user_id = '$id_log' limit 1";

		$DB = new connect_database();
		$result = $DB->read_1($query);

		if($result)
		{
			//retrieves a user record from the first result of the row whcih is 0 (first result) and then return it to the varaible $row
			$row = $result[0];
			return $row;
		}else
		{
			return false;
		}
	}

	public function retrieve_user($id_log)
	{
		$query = "select * from users where user_id = '$id_log' limit 1";
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

	public function retrieve_buddies($id_log)
	{
		$query = "select * from users where user_id != '$id_log' ";
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

		public function get_following($id, $type){

		$DB = new connect_database();
		$type = addslashes($type);

		if(is_numeric($id)){

			//get following details
			$sql = "select following from reacts where type='$type' && content_id = '$id' limit 1";
			$result = $DB->read_1($sql);
			if(is_array($result)){

				$following = json_decode($result[0]['following'], true);
				return $following;
			}
		}

		return false;
	}

	public function follow_buddy($id, $type, $studious_user_id){

		
		if($id == $studious_user_id && $type == 'user'){
				return;
			}
			$DB = new connect_database();

			//save reacts information
			$sql = "select following from reacts where type='$type' && content_id = '$studious_user_id' limit 1";
			$result = $DB->read_1($sql);
			if(is_array($result)){

				$reacts = json_decode($result[0]['following'], true);

				$user_ids = array_column($reacts, "user_id");

				if(!in_array($id, $user_ids)){

					$arr["user_id"] = $id;
					$arr["date"] = date("Y-m-d H:i:s");

					$reacts[] = $arr;
					// javascript object notation -  converts array into a string
					$reacts_string = json_encode($reacts);
					$sql = "update reacts set following = '$reacts_string' where type='$type' && content_id = '$studious_user_id' limit 1";
					$DB->save_1($sql);



				}else{

					//removes a memory location (removes react value if clicked twice by the same user)
					$memory_key = array_search($id, $user_ids);
					unset($reacts[$memory_key]);

					$reacts_string = json_encode($reacts);
					$sql = "update reacts set following = '$reacts_string' where type='$type' && content_id = '$studious_user_id' limit 1";
					$DB->save_1($sql);

				}
				

			}else{

				$arr["user_id"] = $id;
				$arr["date"] = date("Y-m-d H:i:s");

				$arr2[] = $arr;

				// javascript object notation -  converts array into a string
				$following = json_encode($arr2);
				$sql = "insert into reacts (type, content_id, following) values ('$type', '$studious_user_id', '$following')";
				$DB->save_1($sql);

			}
		

	}
	
}
