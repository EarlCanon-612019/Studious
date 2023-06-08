<?php
	session_start();

	include("classes/connect.php");
	include("classes/login.php");

	$email = "";
	$password = "";
	
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	
	{
		$login = new Login();
		$result = $login->evaluate($_POST);

		if($result != "")
		{
			echo "<div style=' text-align: center; font-size: 12px; color: red; background-color: white; font-size: 14px; font-weight: bold; word-spacing: 5px; font-family: 'Roboto Slab'>";
			echo "<br>The following errors occured:<br><br>";
			echo $result;
			echo "</div>";
		}else
		{

			// a header is an information that the server sends to the browser what content is inside the sytem as well as other things like where to redirect.

			header("Location: profile.php");
			die; //system tells the script to end here if the header function happens.
		}

		//these variables are responsible for retaining the values in the Email and Password input

		$email = $_POST['email'];
		$password = $_POST['password'];
	
}
?>


<html> 

	<head>
		<title> StudyHub | Log in </title>
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
			margin-right: 10px;

		}
		#login_container{
			background: white;
			width:700px; 
			height: 400px;
			margin: auto;
			margin-top: 50px;
			padding: 10px;
			text-align: center;	
			padding-top: 60px;
			margin-right: 300px;
			padding-bottom: 20px;
			box-shadow: 10px 10px black;

		}

		#form_contents{

			margin-top: 200px;
		}

		#text{
			height: 40px;
			width: 500px;
			border-radius: 17px;
			border: solid 1px black;
			padding: 4px;
			font-size: 13px;
			background-color: #f2efeb;
			margin-top: 5px;
		}

		.submit_btn {
		  font-size: 17px;
		  text-align: center;
		  cursor: pointer;
		  outline: none;
		  color: #fff;
		  background: #022135;
		  border: 2px solid black;
		  border-radius: 10px;
		  width: 150px;
		  height: 40px;
		  font-family: 'Roboto Slab';
		  font-weight: bold;
		  letter-spacing: 1px;

		}

		.submit_btn:hover {
			background: white;
			border: 2px solid black;
			color: black;
		}

		.submit_btn:active {
		  background-color: #3e8e41;
		  box-shadow: 0 3px 10px rgb(0 0 0 / 0.5);
		  transform: translateY(4px);
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
		  width: 200px;
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

		#emailpass{
			font-family: 'Roboto';
			font-weight: bold;
			margin-bottom: 10px;
			
		}

		
	</style>

	<body style="  background: #F2EFEB;">
		
		<div id= "topBar" >
			<!-- Studious Header -->
			<img src="HEADERLOGO.png" style="float:left; width: auto; height: 120px; margin-top: -4px;">

			<div style="font-size: 45px; margin-top: 20px; margin-left: 90px; font-family: 'Bruno Ace SC' ;">Studious</div> 
			
		</div>

		<div id="login_container">	

		<!--<img src="Designer.gif" style="float:left; width: auto; height: 480px; margin-top: -60px; margin-left: -650px; border-bottom-left-radius: 15px; border-top-left-radius: 15px;">-->

			<img src="2ndFinal.png" style="float:left; width: auto; height: 480px; margin-top: -60px; margin-left: -450px; border-bottom-right-radius: 0px; border-top-right-radius: 0px; box-shadow: 10px 10px black;">
			
			

			<form method="post" style="margin-right: -19px; margin-top: -40px;" id="form_contents">
				
				
			<br><br>
				
				<h1 style="font-family: Bruno Ace SC; font-size: 40px;">Login</h1>
			
				<span style="margin-left: -370px; margin-top: -40px;" id="emailpass">Username or Email</span><br>

				<input value = "<?php echo $email ?>"type="text" placeholder=" " name="email" id="text"><br><br>

				<span>
				<!--<img src="padlock.png" style="width: auto; height: 22px; margin-left: -29px; padding-right: 5px;">-->

				</span>
				<span style="margin-left: -430px;" id="emailpass">Password</span><br>

				<input value = "<?php echo $password ?>"type="password" placeholder=" " name="password" id="text"><br><br>

				<input type="Submit" value="Login" class="submit_btn"><br>

				<div style="font-family: Roboto Slab; font-weight: bolder; color">or</div><br>

				<a href="signup.php" type="Submit" value="Sign-Up" class="signup_btn">

					Sign-Up
				</a>
				
				<!--<div id="signup_btn">Sign-up</div>-->

			</form>
		</div>

		

	</body>

</html>



