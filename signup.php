<?php

	include("classes/connect.php");
	include("classes/signup.php");

	$first_name = "";
	$last_name = "";
	$gender = "";
	$email = "";
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{

		$signup =new Signup();
		$result = $signup->evaluate($_POST);

		if($result != "")
		{
			echo "<div style='text-align: center; font-size: 13px; color: white; background-color: grey; font-family: Tahoma>";
			echo "<br>The following errors occured:<br><br>";
			echo $result;
			echo "</div>";
		}else
		{

			// a header is an information that the server sends to the browser what content is inside the sytem as well as other things like where to redirect.

			header("Location: login.php");
			die; //system tells the script to end here if the header function happens.
		}



	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$gender = $_POST['gender'];
	$email = $_POST['email'];
		
	}


	
	
?>

<html> 

	<head>
		<title> Studious | Signup </title>
	</head>

	<style>
		@import url('https://fonts.googleapis.com/css2?family=Bruno+Ace+SC&family=Oleo+Script&family=Roboto+Slab:wght@300&display=swap');


		#topBar{
			height: 90px;  
			background-color: #022135; 
			color: white; 
			font-family: 'Bruno Ace SC' ;
			padding: 4px;
		}

		#signup_btn{
			background-color: green;
			font-family: tahoma;
			width: 70px;
			text-align: center;
			padding: 4px;
			box-shadow: 6px;
			border-radius: 4px;
			float: right;

		}
		#login_container{
			background: white;
			width:700px; 
			height: 650px;
			margin: auto;
			margin-top: 50px;
			padding: 10px;
			text-align: center;	
			padding-top: 30px;
			margin-right: 300px;
			padding-bottom: 20px;
			box-shadow: 10px 10px black;
			font-size: 20px;


		}
		#text{
			height: 40px;
			width: 300px;
			border-radius: 5px;
			border: solid 1px #aaa;
			padding: 4px;
			font-size: 15px;
			fo
		}

		#submit_btn {
		  font-size: 17px;
		  text-align: center;
		  cursor: pointer;
		  outline: none;
		  color: #fff;
		  background: #022135;
		  border: none;
		  border-radius: 10px;
		  width: 140px;
		  height: 43px;
		  font-family: 'Roboto Slab';
		  font-weight: bold;
		  letter-spacing: 1px;
		  text-decoration: none;
		  padding: 10px;
		  margin-bottom: 5px;
		  padding-left: 40px;
		  padding-right: 40px;
		}

		#submit_btn:hover {

			color: black;
			background-color: white;
			border: 2px solid black;
		}

		#submit_btn:active {
		    background-color: #3e8e41;
		  box-shadow: 0 3px 10px rgb(0 0 0 / 0.5);
		  transform: translateY(4px);
		}
		#form_contents{

			margin-top: 20px;
			font-size: 20px;
			
		}
		#text{
			height: 40px;
			width: 500px;
			border-radius: 17px;
			border: solid 1px black;
			padding-left: 10px;
			font-size: 15px;
			background-color: #f2efeb;
			margin-top: 5px;
			font-family: 'Roboto Slab';
			font-weight: bold;
		}

		.signup_btn {
		  font-size: 17px;
		  text-align: center;
		  cursor: pointer;
		  outline: none;
		  color: #fff;
		  background: #022135;
		  border: none;
		  border-radius: 10px;
		  width: 100px;
		  height: 40px;
		  font-family: 'Roboto Slab';
		  font-weight: bold;
		  letter-spacing: 1px;
		  text-decoration: none;
		  padding: 10px;
		  margin-bottom: -10px;
		  padding-left: 40px;
		  padding-right: 40px;
		}

		.signup_btn:hover {

			color: black;
			background-color: white;
			border: 2px solid black;
		}

		.signup_btn:active {
		   background-color: #3e8e41;
		  box-shadow: 0 3px 10px rgb(0 0 0 / 0.5);
		  transform: translateY(4px);
		}
	</style>

	<body style="background: #F2EFEB;">
		
		<div id= "topBar" >
			<!-- Studious Header -->
			<img src="HEADERLOGO.png" style="float:left; width: auto; height: 120px; margin-top: -4px;">

			<div style="font-size: 45px; margin-top: 20px; margin-left: 90px; font-family: 'Bruno Ace SC' ;">Studious</div> 
			
		</div>
		
		<div id="login_container">	
	<img src="2ndFinal.png" style="float:left; width: auto; height: 700px; margin-top: -30px; margin-left: -640px; border-bottom-right-radius: 0px; border-top-right-radius: 0px; box-shadow: 10px 10px black;">
			<span style="font-size: 40px; font-family: Roboto Slab;" >Join Studious</span>


			<form method="post" action="" id="form_contents">
				
				
				<input value="<?php echo $first_name ?>" type="text" placeholder="First Name" name="first_name" id="text"><br><br>
				<input value="<?php echo $last_name ?>" type="text" placeholder="Last Name" name="last_name" id="text"><br><br>

				<span style="font-weight: normal; font-family: 'Roboto Slab'; font-size: 20px;">Gender</span><br>
				<select id="text" name="gender"> 

					<option><?php echo $gender ?></option>
					<option>Male</option>
					<option>Female</option>

				</select>
				<br><br>

				<input value="<?php echo $email ?>" type="text" placeholder="Email" name="email" id="text"><br><br>
				<input type="password" placeholder="Password" name="password" id="text"><br><br>
				<input type="password" placeholder="Confirm Password" name="password2" id="text"><br><br>

				<input type="submit" value="Signup" id="submit_btn">

				
				<div style="font-family: Roboto Slab; font-weight: bolder; color; margin-bottom: 13px;">or</div>

				<a href="login.php" type="Submit" value="Sign-Up" class="signup_btn">
					Log-in
				</a>

				<br><br><br>

			</form>

		</div>

	</body>

</html>
