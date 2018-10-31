<?php
	header('Content-type: application/json');
	header('Accept: application/json');

	$servername = "localhost";
	$serverUserName = "root";
	$serverPassword = "";
	$databaseName = "TestDB";

	$connection = new mysqli($servername, $serverUserName, $serverPassword, $databaseName);

	if ($connection->connect_error)
	{
		header("HTTP/1.1 500 Bad connection, portal is down");
		die("The server is down, we couldn't retrieve data from the data base");
	}
	else
	{

		$uName = $_GET["username"];
		#if($_SERVER['REQUEST_METHOD'] == 'GET') 
		#{
			#parse_str($_SERVER['QUERY_STRING'], $getVariables);
			#$uName = $getVariables["username"];

			#parse_str(file_get_contents("php://input"),$post_vars);
    		#echo $post_vars['username']." is the fruit\n";

			$uPassword = $_GET["password"];

			$sql = "SELECT fName, lName, passwrd
					FROM Users
					WHERE username='$uName'";
				
			$result = $connection->query($sql);
			$pass = $result->fetch_assoc();
			$pass = $pass["passwrd"];


			if ($result->num_rows > 0 && password_verify ($uPassword, $pass))
			{
				// Once we verify the user is who he claims he is is, we do the session part.

				// When the session has already been created with session_start and we use the start again we open the session.
				session_start();
				while ($row = $result->fetch_assoc())
				{
					$response = array("firstName" => $row["fName"], "lastname" => $row["lName"]);
					// On the session array, we specify the name of the variable.
					$_SESSION['firstName'] = $row["fName"];
					$_SESSION['lastName'] = $row["lName"];
					$_SESSION['userName'] = $uName;
				}
				echo json_encode($response);
			}
			else
			{
				header("HTTP/1.1 406 User not found");
				die("Wrong credentials provided");
			} 
		#}
	}

?>










