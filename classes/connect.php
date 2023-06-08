<?php



class connect_database
{

	private $host = "localhost";
	private $username = "root";
	private $password = "";
	private $db = "studious_db";


	function connect_1()
	{
		$connection = mysqli_connect($this->host, $this->username, $this->password, $this->db );	
		return $connection;
	}

	function read_1($query)
	{
		
		$conn = $this->connect_1();
		$result = mysqli_query($conn, $query);

		if(!$result)
		{
			return false;
		}
		else
		{
			$data = false;
			while($row = mysqli_fetch_assoc($result))
			{
				$data[] = $row;
		
			}

			return $data;
		}
	}

	function save_1($query)
	{
	
		$conn = $this->connect_1();
		$result = mysqli_query($conn, $query);

		if(!$result)
		{
			return false;
		}else
		{
			return true;
		}
		
	}	

}











