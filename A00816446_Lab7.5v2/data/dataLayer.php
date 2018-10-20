<?php
	
	function connect()
	{
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "weblab";

	    $connection = new mysqli($servername, $username, $password, $dbname);

	    if ($connection->connect_error) {
			//Should be a message a typical user could understand in production
			exit('Error connecting to database'); 
	    	return null;
	    }
	    else
	    {
			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
			$connection->set_charset("utf8mb4");
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

		if ($conn) 
		{

			$sqlStatement = "SELECT userId, userPwd FROM useraccounts WHERE username = :uName AND userPwd = :uPass";

			$prepared_stmt = $conn->prepare($sqlStatement);

			$prepared_stmt -> bindParam(':uName', $username);
			$prepared_stmt -> bindParam(':userPwd', $pwd);

			if (!$prepared_stmt->execute()) 
			{
				$response = array('status' => "Bad Connection. Something went wrong while trying to communicate", 'code' => 500);
				$conn -> close();
			}
			else
			{
				$prepared_stmt->store_result();
				$prepared_stmt->bind_result($unId,$uPass);
				$prepared_stmt->fetch();

				if ($uPass === $pwd) 
				{
					session_start();
	                $_SESSION['userId'] = $unId;
					$prepared_stmt->free_result();
               		$prepared_stmt->close();
					$conn -> close();
					return array('status' => "Success", 'code' => 200);
				}
				else 
				{
					return array('status' => "Invalid user password combination", "code" => 406);
					$conn -> close();
				}
				return array('status' => "Bad Connection. Something went wrong while trying to communicate", "code" => 500);
				$conn -> close();
			}
		}
		else 
		{
			# Generic error msg. The status is important, the code should be a little more general.
			return array('status' => "Internal server error", "code" => 500);
		}
	}

?>