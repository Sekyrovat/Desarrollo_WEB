<?php
	
	function connect(){

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "weblab";

		$connection = new mysqli($servername, $username, $password, $dbname);


	    if ($connection -> connect_error) {
	    	return null;
			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	    }
	    else
	    {
			$connection -> set_charset("utf8mb4");
	    	return $connection;
	    }
	}


	function userName_exits($userName)
	{
		$conn = connect();
		if ($conn) 
		{
			$sqlStatement = "SELECT userId FROM useraccounts WHERE username = ?";

		    $prepared_stmtForUserNameValidation = $conn -> prepare($sqlStatement);
		    $prepared_stmtForUserNameValidation -> bind_param("s", $userName);
		    # $prepared_stmtForUserNameValidation -> bind_param("s", $userName1);
		    # $userName1 = $userName;
		    
		    $prepared_stmtForUserNameValidation -> execute();
		    $prepared_stmtForUserNameValidation -> store_result();

		    if ($prepared_stmtForUserNameValidation -> num_rows() > 0) 
		    {
		        $prepared_stmtForUserNameValidation -> free_result();
		        $prepared_stmtForUserNameValidation -> close();
		        $conn -> close();
		        return array('status' => "Success", "code" => 200);
		    } 
		    else 
		    {
		        $prepared_stmtForUserNameValidation -> free_result();
		        $prepared_stmtForUserNameValidation -> close();
		        $conn -> close();
		        return array('status' => "Not_Found", "code" => 409);
		    }
		}
		else
		{
			return array('status' => "Internal Server Error", 'code' => 500);
		}
	}

	# Application will send us the data prepared, so we just need to set the query.
	function attemptLogin($username, $pwd)
	{
		$conn = connect();

		if ($conn) 
		{

			$sqlStatement = "SELECT userId FROM useraccounts WHERE username = '$username' AND userPwd = ?";

			$prepared_stmt = $conn -> prepare($sqlStatement);
	        $prepared_stmt -> bind_param("s",$pwd1);

	        $pwd1 = $pwd;

	        $conditionHandler = $prepared_stmt -> execute();
			if (!$conditionHandler) 
	        {
	        	/* free results */
		        /* close statement */
		        # Puede que se deban quitar las de conditionHandler.
	        	$conditionHandler -> free_result();
		        $prepared_stmt -> free_result();
		        $conditionHandler -> close();
		        $prepared_stmt -> close();
				$conn -> close();
	        	return array('status' => 'Internal server error.', 'code' => 500);
	        }

	        $prepared_stmt -> store_result();

	        if ($prepared_stmt -> num_rows() === 0) 
	        {
	        	/* free results */
		        /* close statement */
	        	$prepared_stmt -> free_result();
		        $prepared_stmt -> close();
		        $conn -> close();
	        	return array('status' => 'Conflict, invalid user password combination.', 'code' => 409);
	        }

            $prepared_stmt -> bind_result($unId);
            $prepared_stmt -> fetch();

	       	/* free results */
	        /* close statement */
        	$prepared_stmt -> free_result();
	        $prepared_stmt -> close();
	        $conn -> close();

	        return array('status' => "Success", 'response' => $unId);
		}
		else
		{
			return array('status' => "Internal Server Error", 'code' => 500);
		}
	}

	function getProfileInfo($uId)
	{
		$conn = connect();

		if ($conn) 
		{
			$query = "SELECT * 
						FROM useraccounts 
						WHERE userId = '$uId';";
			$prepared_stmt = $conn -> prepare($query);

			if (!$prepared_stmt -> execute()) 
		    {
		    	return array('status' => "Bad connection, something went wrong while saving your data, please try again later", 'code' => 500);
		    }
		    else 
		    {       
		        $result = $prepared_stmt -> get_result();

		        $arrOfData = array();
		        $row = mysqli_fetch_assoc($result);

		        $response = array("userCountry" => $row["userCountry"], "userEmail" => $row["userEmail"], "userFiName" => $row["userFiName"], "userLaName" => $row["userLaName"], "userGender" => $row["userGender"], "username" => $row["username"], "userProfilePic" => $row["userProfilePic"]);

		        return array('status' => 200, 'response' => $response);
		        /* free results */
		        /* close statement */
		        $prepared_stmt -> free_result();
		        $prepared_stmt -> close();
		        $conn -> close();
		    }
		}
		else
		{
			return array('status' => "Internal Server Error", 'code' => 500);
		}

	}

?>