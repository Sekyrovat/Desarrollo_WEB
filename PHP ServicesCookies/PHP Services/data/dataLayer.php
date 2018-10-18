<?php
	
	function connect(){
		$servername = "localhost";
	    $username = "root";
	    $password = "";
	    $dbname = "TestDB";

	    $connection = new mysqli($servername, $username, $password, $dbname);

	    if ($connection->connect_error) {
	    	return null;
	    }
	    else
	    {
	    	return $connection;
	    }
	}

	/*
		The application filters the presentation and the data layer uses that as input.
	*/

	# Application will send us the data prepared, so we just need to set the query.
	function attemptLogin($username, $pwd)
	{
		$conn = connect();

		if ($conn) {

			$sqlStatement = "SELECT * FROM Users WHERE username = '$username' AND passwrd = '$pwd'";

			$result = $conn -> query($sqlStatement);

			if ($result -> num_rows > 0) {
				while ($row = $result->fetch_assoc())
				{
					$response = array("firstName" => $row["fName"], "lastname" => $row["lName"]);
					# On the session array, we specify the name of the variable.
					# $_SESSION['firstName'] = $row["fName"];
					# $_SESSION['lastName'] = $row["lName"];
					# $_SESSION['userName'] = $uName;
				}
				$conn -> close();
				return array('status' => "Success", 'response' => $response);
			} 
			else 
			{
				return array('status' => "Not_Found", "code" => 406);
				$conn -> close();
			}
			

			$conn -> close();
		} 
		else {
			# Generic error msg. The status is important, the code should be a little more general.
			return array('status' => "Internal server error", "code" => 500);
		}
	}

?>