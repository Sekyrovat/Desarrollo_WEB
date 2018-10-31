<?php
	
	function connect(){
		$servername = "localhost";
	    $username = "root";
	    $password = "";
	    $dbname = "weblab";

	    $connection = new mysqli($servername, $username, $password, $dbname);

	    if ($connection->connect_error) {
	    	return null;
	    }
	    else
	    {
	    	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
			$connection->set_charset("utf8mb4");
	    	return $connection;
	    }
	}

	/**
	 * Attempt to login the user.
	 *
	 * @param String $username
	 *  Username proposed by the user.
	 * @param String $userFiName
	 *  User's First name.
	 * @param String $userLaName
	 *  User's Last name.
	 * @param String $userEmail
	 *  User's email.
	 * @param String $userPwd
	 *  Password given by the user.
	 * @param String $userGender
	 *  User's gender.
	 * @param String $userCountry
	 *  User's current country.
	 * @return Array status and code
	 * Status 				-> Code 
	 *  Ok, aka success		 -> 200
	 *  User not found.		 -> 406
	 *  Invalid combination. -> 409
	 *  Bad connection. 	 -> 500
	 */
	function attemptRegistration($username, $userFiName, $userLaName, $userEmail, $userPwd, $userGender, $userCountry)
	{
		$conn = connect();

		if ($conn) 
		{
			if (userName_exits($username)) 
			{
				$conn -> close();
				return array('status' => "Username already registered", "code" => 409);
			}
			elseif (userEmail_exits($userEmail)) 
			{
			 	$conn -> close();
				return array('status' => "Email already registered", "code" => 409);
			}
			else
			{
				$query = "INSERT INTO useraccounts (username, userFiName, userLaName, userEmail, userPwd, userGender, userCountry)
				VALUES (?, ?, ?, ?, ?, ?, ?)";
				$prepared_stmt = $conn->prepare($query);
				$prepared_stmt->bind_param("sssssss", $username, $userFiName, $userLaName, $userEmail, $userPwd, $userGender, $userCountry);

			    if ($prepared_stmt->execute()) 
			    {
			        $conn -> close();
					return array('status' => "success", "code" => 200);
			    } 
			    else 
			    {
			    	$conn -> close();
					return array('status' => "Bad connection, something went wrong while saving your data, please try again later", "code" => 500);
			    }
			} 
		}
		else 
		{
			return array('status' => "Internal server error", "code" => 500);
		}
	}



	/**
	 * Function to create the first register of a friendship
	 * before it is confirmed by the seconduser. Here we 
	 * insert the friendship with a P for Pending.
	 * @param Integer $uId
	 * 	Used to keep the Id of the user sending the request.
	 * @param String $newFriendUserName
	 *  Used to keep the name of the new friend, which was
	 *	 obtained from the front-end, once the username is
	 *   taken the id is obtained via a query.
	 * @return Array
	 * 	Returns an array with the status and code.
	 */
	function addFriend($uId, $newFriendUserName)
	{
		$conn = connect();
		if ($conn) 
		{
			$query = "SELECT userId FROM useraccounts WHERE username = ?;"
			$stmt = $conn->prepare($query);
			$stmt -> bindparam('s',$newFriendUserName);

			if ($stmt -> execute()) 
			{
				$stmt -> store_result();
				$stmt ->bind_result($NewFriendUserId);
				$stmt -> fetch();

				$secondQuery = "INSERT INTO friendrelations (user1, user2, areFriends) VALUES ($uId, $NewFriendUserId, 'P')";

				$prepared_stmt -> prepare($secondQuery);

				if ($prepared_stmt->execute())
				{
					$stmt -> close();
					$prepared_stmt -> close();
					$conn -> close();
					return array('status' => 'success', 'code' => 200);
				}
				$stmt -> close();
				$conn -> close();
				return array('status' => 'Something went wrong while trying to add your friend.', 'code' => 409);
			} 
			else
			{
				$conn -> close();
				return array('status' => 'Something went wrong while trying to add your friend.', 'code' => 409);
			}
		}
		else
		{
			return array('status' => "Internal server error", "code" => 500);
		}
	}

	/**
	 * Function to create the first register of a friendship
	 * before it is confirmed by the seconduser. Here we 
	 * insert the friendship with a P for Pending.
	 * @param Integer $uId
	 * 	Used to keep the Id of the user sending the request.
	 * @param String $newFriendUserName
	 *  Used to keep the name of the new friend, which was
	 *	 obtained from the front-end, once the username is
	 *   taken the id is obtained via a query.
	 * @return Array
	 * 	Returns an array with the status and code.
	 */
	function confirmFriend($uId, $newFriendUserName)
	{
		$conn = connect();
		if ($conn) 
		{
			$query = "SELECT userId FROM useraccounts WHERE username = ?;"
			$stmt = $conn->prepare($query);
			$stmt -> bindparam('s',$newFriendUserName);

			if ($stmt -> execute()) 
			{
				$stmt -> store_result();
				$stmt ->bind_result($NewFriendUserId);
				$stmt -> fetch();

				$secondQuery = "UPDATE friendrelations SET areFriends = 'Y' WHERE ((user1 = $NewFriendUserId AND user2 = $uId) OR (user2 = $NewFriendUserId AND user1 = $uId)) AND reFriends = 'P';";

				$prepared_stmt -> prepare($secondQuery);

				if ($prepared_stmt->execute())
				{
					$stmt -> close();
					$prepared_stmt -> close();
					$conn -> close();
					return array('status' => 'success', 'code' => 200);
				}
				$stmt -> close();
				$conn -> close();
				return array('status' => 'Something went wrong while trying to add your friend.', 'code' => 409);
			} 
			else
			{
				$conn -> close();
				return array('status' => 'Something went wrong while trying to add your friend.', 'code' => 409);
			}
		}
		else
		{
			return array('status' => "Internal server error", "code" => 500);
		}
	}

	function displayFriends($uId)
	{
		$conn = connect();
		if ($conn) 
		{
			$query = "SELECT username, userProfilePic, userCountry, userId, FROM useraccounts WHERE userId IN (SELECT user1 FROM friendrelations WHERE (user1 = ? OR user2 = ?) AND areFriends = 'Y') OR userId IN (SELECT user2 FROM friendrelations WHERE (user1 = ? OR user2 = ?) AND areFriends = 'Y');";

				$stmt = $conn->prepare($query);
				$stmt->bind_param("iiii", $uId, $uId, $uId, $uId);
				if ($stmt->execute())
				{
				    $result = $stmt->get_result();
				    $arrOfFriends = array();

				    while($row = mysqli_fetch_assoc($result)) 
				    {
				    	if($row['userId'] !== $uId)
				    	{
					        $currentRow = array("userName" => $row["username"], "userProfilePic" => $row["userProfilePic"]);
					        array_push($arrOfFriends, $currentRow);
				    	}
				    }
				    return array('status' => "success", "code" => 200, 'response' => $arrOfFriends);
				} 
				else {
				    return array('status' => "Bad connection, retrieval error", "code" => 500);
				}	
		}
		else
		{
			return array('status' => "Internal server error", "code" => 500);
		}
	}

	function displayNewPossibleFriends($uId)
	{
		$conn = connect();
		if ($conn) 
		{
			$query = "SELECT username, userProfilePic, userCountry, userId, FROM useraccounts WHERE userId NOT EXISTS (SELECT user1 FROM friendrelations WHERE (user1 = ? OR user2 = ?) AND (areFriends = 'P' OR areFriends = 'Y') AND userId NOT EXIST (SELECT user2 FROM friendrelations WHERE (user1 = ? OR user2 = ?) AND (areFriends = 'P' OR areFriends = 'Y'));";

				$stmt = $conn->prepare($query);
				$stmt->bind_param("iiii", $uId, $uId, $uId, $uId);
				if ($stmt->execute())
				{
				    $result = $stmt->get_result();
				    $arrOfNewPossibleFriends = array();

				    while($row = mysqli_fetch_assoc($result)) 
				    {
				    	if($row['userId'] !== $uId)
				    	{
					        $currentRow = array("userName" => $row["username"], "userProfilePic" => $row["userProfilePic"]);
					        array_push($arrOfNewPossibleFriends, $currentRow);
				    	}
				    }
				    return array('status' => "success", "code" => 200, 'response' => $arrOfNewPossibleFriends);
				} 
				else {
				    return array('status' => "Bad connection, retrieval error", "code" => 500);
				}	
		}
		else
		{
			return array('status' => "Internal server error", "code" => 500);
		}
	}

	function incomingFriendRequestDisplayer($uId)
	{
		$conn = connect();
		if ($conn) 
		{
			$query = "SELECT userId FROM friendrelations WHERE user2 = ? AND areFriends = 'P';"
			$stmt = $conn->prepare($query);
			$stmt -> bindparam('i',$uId);

			if ($stmt->execute())
			{
				$result = $stmt->get_result();
			    $arrOfRequests = array();

			    while($row = mysqli_fetch_assoc($result)) 
			    {
			    	if($row['userId'] !== $uId)
			    	{
				        $currentRow = array("userName" => $row["username"], "userProfilePic" => $row["userProfilePic"]);
				        array_push($arrOfRequests, $currentRow);
			    	}
			    }
			    return array('status' => "success", "code" => 200, 'response' => $arrOfRequests);
			}
			else
			{
			$stmt -> close();
			$conn -> close();
			return array('status' => 'Something went wrong while trying to add your friend.', 'code' => 409);
			}
		}
		else
		{
			return array('status' => "Internal server error", "code" => 500);
		}
	}

	/**
	 * Attempt to login the user.
	 *
	 * @param String $username
	 *  Username proposed by the user.
	 * @param String $pwd
	 *  Password given by the user.
	 *
	 * @return Array status and code
	 * Status 				-> Code 
	 *  Ok, aka success		 -> 200
	 *  User not found.		 -> 406
	 *  Invalid combination. -> 409
	 *  Bad connection. 	 -> 500
	 */
	function attemptLogin($username, $pwd)
	{
		$conn = connect();
		if ($conn) 
		{
			if (userName_exits($username)) 
			{
				$conn -> close();
				return array('status' => "User not found", "code" => 406);
			} 
			else 
			{
				$query = "SELECT userId 
						FROM useraccounts 
						WHERE username = ? AND userPwd = ?";

				$prepared_stmt = $conn -> prepare($query);

				$prepared_stmt -> bind_param( 'ss', $username, $pwd );

				if ($prepared_stmt -> execute()) 
				{
					$prepared_stmt -> store_result();
					$prepared_stmt ->bind_result($uId);
					$prepared_stmt -> fetch();
					$prepared_stmt -> close();
					$conn -> close();
					return array('status' => 'success', 'code' => 200, 'response' => $uId);
				} 
				else
				{
					$conn -> close();
					return array('status' => 'Invalid user password combination', 'code' => 409);
				}
			}
		}
		else
		{
			return array('status' => "Internal server error", "code" => 500);
		}
	}


	/**
	 * Check if a user with given username exists.
	 *
	 * @param String $userName
	 *  The username of the new user..
	 *
	 * @return Boolean
	 *  True -> User exists.
	 *  False -> User does not exists.
	 */
	function userName_exits($userName)
	{
		$conn = connect();

	    $prepared_stmtForUserNameValidation = $conn -> prepare('SELECT * FROM useraccounts WHERE username = ?');
	    $prepared_stmtForUserNameValidation -> bind_param('s' , $userName);

	    $prepared_stmtForUserNameValidation -> execute();

	    if ($prepared_stmtForUserNameValidation -> num_rows() === 0) 
	    {
	        $prepared_stmtForUserNameValidation -> close();
	        return false;
	    }
	    else
	    {
	        $prepared_stmtForUserNameValidation -> close();
	        return true;
	    }
	}

	/**
	 * Check if a user with given e-mail exists.
	 *
	 * @param String $email
	 *  The e-mail to id the user.
	 *
	 * @return Boolean
	 *  True -> User exists.
	 *  False -> User does not exists.
	 */
	function userEmail_exits($email)
	{
		$conn = connect();

	    $prepared_stmtForEmailValidation = $conn->prepare('SELECT * FROM useraccounts WHERE userEmail = ?');

	    $prepared_stmtForEmailValidation -> bind_param("s", $email);

	    $prepared_stmtForEmailValidation -> execute();
	    # $prepared_stmtForEmailValidation -> store_result();
	    
	    if ($prepared_stmtForEmailValidation -> num_rows() === 0) {
	        $prepared_stmtForEmailValidation -> close();
	        return false;
	    } else {
	        $prepared_stmtForEmailValidation -> close();
	        return true;
	    }
	}

	/**
	 * Function to obtain the user's data to 
	 * either display it or use it.
	 * @return Array, status, code, response
	 *  Status 				-> Code -> Response 
	 *  Ok, aka success		 -> 200 -> response
	 *  User not found.		 -> 406
	 *  Invalid combination. -> 409
	 *  Bad connection. 	 -> 500 
	 */
	function getUserData($temp)
	{
		$conn = connect();

		if ($conn) 
		{
			$query = "SELECT * FROM useraccounts WHERE userId = ?;";
		    $stmt = $conn->prepare($query);
		    $stmt->bind_param("i", $temp);

	        if (!$stmt->execute()) 
		    {
		    	$conn -> close();
				return array('status' => "Bad connection, something went wrong while saving your data, please try again later.", "code" => 500);
		    }
		    else
		    {       
		        $result = $stmt->get_result();

		        $arrOfData = array();
		        $row = mysqli_fetch_assoc($result);

		        $arrOfData = array("userCountry" => $row["userCountry"], "userEmail" => $row["userEmail"], "userFiName" => $row["userFiName"], "userLaName" => $row["userLaName"], "userGender" => $row["userGender"], "username" => $row["username"], "userProfilePic" => $row["userProfilePic"]);

		        /* free results */
		        /* close statement */
		        $stmt->free_result();
		        $stmt->close();
		        
		        return array('status' => 'success', 'code' => 200, 'response' => $arrOfData);
		    }
		} 
		else
		{
			return array('status' => "Internal server error", "code" => 500);
		}
	}

	/**
	 * Function to obtain all posts that a certain 
	 * user is allowed to see. This includes, posts
	 * made by him or a confirmed friend.
	 * @param Integer $temp
	 *  Used to keep the current user's ID.
	 * @return array
	 * 	The array contains all the posts that match the 
	 * criteria.
	 */
	function getPosts($temp)
	{
		$conn = connect();
		if ($conn) 
		{
			$query = "SELECT pt1.postPosterId, pt1.postText, pt1.postImage, useraccounts.userId, useraccounts.username, useraccounts.userProfilePic FROM (SELECT userposts.postPosterId, userposts.postText, userposts.postImage FROM userposts WHERE userposts.postPosterId = ? OR userposts.postPosterId = (SELECT user1 FROM friendrelations WHERE (user1 = ? OR user2 = ?) AND areFriends = 'Y') OR userposts.postPosterId = (SELECT user2 FROM friendrelations WHERE (user1 = ? OR user2 = ?) AND areFriends = 'Y')) as pt1 INNER JOIN useraccounts ON pt1.postPosterId=useraccounts.userId";

				$stmt = $conn->prepare($query);
				$stmt->bind_param("iiiii", $temp, $temp, $temp, $temp, $temp);
				if ($stmt->execute())
				{
				    $result = $stmt->get_result();
				    $arrOfPosts = array();

				    while($row = mysqli_fetch_assoc($result)) 
				    {
				        $currentRow = array("posterId" => $row["postPosterId"], "postText" => $row["postText"], "postImage" => $row["postImage"], "posterProfilePic" => $row["userProfilePic"], "posterUserName" => $row["username"]);
				        array_push($arrOfPosts, $currentRow);
				    }
				    return array('status' => "success", "code" => 200, 'response' => $arrOfPosts);
				} 
				else {
				    return array('status' => "Bad connection, retrieval error", "code" => 500);
				}	
		}
		else
		{
			return array('status' => "Internal server error", "code" => 500);
		}
	}

	/**
	 * Funtion used when the user is creating a new post.
	 * It adds the post to the database with all it's
	 * related info.
	 * @param Integer $uId
	 *  Used to keep the current user's ID.
	 * @param String $postText
	 *  Used to store the input the user has given.
	 * @param Image $postImage
	 *  The image will be send to the file system, once in 
	 *	 the file system the location will be placed in the 
	 *	 database to keep from using data blob in the database.
	 * @return Array
	 *  It returns an array containing the end status of the
	 * 	query.
	 */
	function newPost($uId, $postText, $postImage)
	{
		$conn = connect();
		if ($conn) 
		{
			$query = "INSERT INTO userposts  ( postPosterId, postText, postImage ) 
            VALUES  ( ?,?,? )";
			$prepared_stmt = $conn -> prepare ( $query );

			$prepared_stmt -> bind_param ( 'iss' , $_SESSION['userId'], $postText, $postImage);
			  
			if  ( $prepared_stmt -> execute() ) {
				$conn -> close();
			    return array ( "status" => "success", 'code' => 200 );
			} else {
				$conn -> close();
			    $prepared_stmt -> close();
			    return array('status' => "Conflict, something went wrong, try again later.", "code" => 500);
			}
		}
		else
		{
			return array('status' => "Internal server error", "code" => 500);
		}
	}

	/**
	 * Function to obtain all the user's friends.
	 * The correct return gives an array with all the 
	 * the info of confirmed friends.
	 * @param Integer $temp
	 *  Used to keep the current user's ID.
	 * @return array
	 * 	The array contains info of the user's confirmed
	 * 	friends. 
	 */
	function getFriends($uId)
	{
		$conn = connect();

		if ($conn) 
		{
			$query = "SELECT username, userProfilePic, userFiName, userLaName FROM useraccounts WHERE userId IN (user1, user2 FROM friendrelations WHERE user1 = ? OR user2 = ? AND areFriends = 'Y');";
		    $stmt = $conn->prepare($query);
		    $stmt->bind_param("ii", $temp, $temp);

	       if ($stmt->execute())
				{
				    $result = $stmt->get_result();
				    $arrOfFriends = array();

				    while($row = mysqli_fetch_assoc($result)) 
				    {
				        $currentRow = array("username" => $row["username"], "profilePic" => $row["userProfilePic"], "firstName" => $row["userFiName"], "lastName" => $row["userLaName"]);
				        array_push($arrOfFriends, $currentRow);
				    }
				    return array('status' => "success", "code" => 200, 'response' => $arrOfFriends);
				} 
				else {
				    return array('status' => "Bad connection, retrieval error", "code" => 500);
				}
		} 
		else
		{
			return array('status' => "Internal server error", "code" => 500);
		}
	}

?>