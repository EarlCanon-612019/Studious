<?php

class Profile
{
	
	function retrieve_profile($id_log){
		//variable escaping = adds slashes on special characters to prevent hacking/ tells sql that special characters such as comas are part of the string
		$id_log = addslashes($id_log);
		$DB = new connect_database();
		$query = "select * from users where user_id = '$id_log' limit 1";
		return $DB->read_1($query);
		 
	}
}