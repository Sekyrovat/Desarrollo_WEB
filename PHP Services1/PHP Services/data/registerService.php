<?php
	
	// PHP code for the login.

	// We need to set up the settings so that the code knows what it will receive and
	// what will be sent.

	// contentType is used to determine the data we send
	
	// Here is how we let the front end know that we are going to send a json file.
	header('Content-type: application/json');
	// Now we specify what we want to receive
	// If we get something sifferent we wwill redirect with an error code.
	header('Accept: application/json');

	// Now we prepare the connection to the database.

	// We require the serverName, localhost or url where it is positioned.
	$serverName = "localhost";
	$serverUserName = "root";
	$serverPassword = "";
	$databaseName = "testdb";

	// This variable will be the one to try to connet to the db
	$connection = new mysqli($serverName, $serverUserName, $serverPassword, $databaseName);

	// We will try the connection, this is to check that we are able to connect
	// We point to the method.
	if($connection->connect_error)
	{
		// We redirect with an error message if the connection could not be
		// established.
		header("HTTP/1.1 500 Bad connection, portal is down.");
		// We need to terminate the connection.
		die("Server is down.");
	}
	else
	{

		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
		 	parse_str(file_get_contents("php://input"),$getVars);
			$uName = $getVars["username"];
		}
		/*
		 * // In case the connection was done succesfully
		 * // We use the GET and we specify the data we are expecting, the properties.
		 * // The parameter needs to be named as we name it here.
		 * $uName = $_POST["username"];
		 * $uPass = $_POST["password"];
		 */

		// Now we create the validation query.
		$sql = "SELECT username
				FROM users
				WHERE username = '$uName';";

		// The SERVER will retun us a result of the query.
		// Now to use the query we do:
		$result = $connection->query($sql);

		// We don't just go and accept the return, we need to validate the info.
		// If we get more than 0 we actually got some info.
		if ($result->num_rows <= 0) {
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
			 	parse_str(file_get_contents("php://input"),$getVars);
				$uFName = $getVars["firstName"];
				$uLName = $getVars["lastName"];
				$uName = $getVars["username"];
				$uPass = $getVars["password"];
			}

			$sql = "INSERT INTO users (fName,lName,username,passwrd) VALUES ('$uFName','$uLName','$uName','$uPass');";

			if (mysqli_query($connection, $sql)) {
				$response = array('status' => "success");
				echo json_encode($response);
			} 
			else {
				header("HTTP/1.1 500 Bad connection, portal is down.");
				// We need to terminate the connection.
				die("Server is down.");
			}

		} else {
			// To reach this point the user must have provided invalid credentials.
			// 406 is the code for an invalid user.
			header("HTTP/1.1 409 Conflict, username already in use");
			die("User with that username already exists");
		}
		
	}

?>