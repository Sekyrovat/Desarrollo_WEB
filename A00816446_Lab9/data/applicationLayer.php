<?php
	# It will respond to every request.
	header('Content-type: application/json');
	header('Accept: application/json');
	# This specifies that every service will recieve and send a json.
	
	# Here is where we would point to another server if we had more than 1.
	require_once __DIR__ . '/dataLayer.php';

	$requestMethod = $_SERVER['REQUEST_METHOD'];

	# The switch is generic. Since it only targets general actions. We need
	# to be more specific with what we want to do. To manage this we use
	# extra functions that will have more specific switches.
	switch ($requestMethod) 
	{
		case 'GET':
			$action = $_GET["action"];
			getRequests($action);
			break;
		case 'POST':
			$action = $_POST['action'];
			postRequests($action);
			break;
		case 'PUT':
			$_PUT = file_get_contents('php://input');
			$action = $_PUT['action'];
			putRequests($action);
			break;
	}


	function getRequests($action)
	{
		switch ($action) {
			case 'LOGIN':
				# Here we call the login from the data layer.
				requestLogin();
				break;
			case 'GET_POSTS':
				requestPosts();
				break;
			case 'GET_DATA':
				requestData();
				break;
			case 'GET_FRIENDS':
				requestFriends();
				break;
		}
	}

	function putRequests($action)
	{
		switch ($action) {
			case 'CONFIRM_FRIEND':
				# Here we call the login from the data layer.
				confirmFriendship();
				break;
		}
	}

	function postRequests($action)
	{
		switch ($action) {
			case 'REGISTER':
				requestRegister();
				break;
			case 'NEW_POST':
				makePost();
				break;
			case 'ADD_FRIEND':
				addNewFriend();
				break;
			case 'LOGOUT':
				attemptLogout();
				break;
		}
	}

	function requestRegister()
	{
		$username = $_POST['username'];
		$userFiName = $_POST['userFiName'];
		$userLaName = $_POST['userLaName'];
		$userEmail = $_POST['userEmail'];
		$userPwd = $_POST['userPwd'];
		$userGender = $_POST['userGender'];
		$userCountry = $_POST['userCountry'];

		$response = attemptRegistration($username, $userFiName, $userLaName, $userEmail, $userPwd, $userGender, $userCountry);

		if ($response['status'] === "success") {
			echo json_encode($response['status']);
		} else {
			errorHandler($response["status"], $response["code"]);
		}
	}

	function makePost()
	{
		session_start();
		if(verifySession())
		{
			$uId = $_SESSION['userId'];

			if  ($_POST['newInput'] === NULL || $_POST['newInput'] === "") {
			    $postText = "";
			} else {
			    $postText = $_POST['newInput'];
			}

			if  ($_POST['newImage'] === NULL || $_POST['newImage'] === "") {
			    $postImage = "";
			} else {
				$postImage = $_POST['newImage'];
			}
			
			$response = newPost($uId, $postText, $postImage);

			if ($response['status'] === "success") 
			{
				echo json_encode(200);
			} 
			else 
			{
				errorHandler($response["status"], $response["code"]);
			}
		}
		else
		{
			errorHandler('User not logged in', 406);
		}
	}

	function addNewFriend()
	{
		session_start();
		if(verifySession())
		{
			$_PUT = file_get_contents('php://input');
			$uId = $_SESSION['userId'];
			$newFriend = $_PUT['newFriendUserName'];
			
			$response = addFriend($uId, $newFriend);

			if ($response['status'] === "success") 
			{
				echo json_encode();
			} 
			else 
			{
				errorHandler($response["status"], $response["code"]);
			}
		}
		else
		{
			errorHandler('User not logged in', 406);
		}

	}

	function requestData()
	{
		session_start();
		if(verifySession())
		{
			$uId = $_SESSION['userId'];
			
			$response = getUserData($uId);

			if ($response['status'] === "success") 
			{
				echo json_encode(array('status' => $response['status'], 'code' => $response['code'], 'response' => $response['response']));
			} 
			else
			{
				errorHandler($response["status"], $response["code"]);
			}
		}
		else
		{
			errorHandler('User not logged in', 406);
		}
	}
	
	function requestPosts()
	{
		session_start();
		if(verifySession())
		{
			$uId = $_SESSION['userId'];

			$response = getPosts($uId);

			if ($response['status'] === "success") {

				echo json_encode(array('status' => 'success', 'code' => 200 , 'response' => $response['response']));
			} else {
				errorHandler($response["status"], $response["code"]);
			}
		}
		else
		{
			errorHandler('User not logged in', 406);
		}
	}

	function requestLogin()
	{
		$uName = $_GET['userName'];
		$pwd = $_GET['userPassword'];

		$response = attemptLogin($uName, $pwd);

		if ($response['status'] === "success") {
			session_start();
			$_SESSION['userId'] = $response['response'];
			echo json_encode(array( 'status' => $response['status'], 'code' => $response['code'], 'user' => $_SESSION['userId']));
		} else {
			errorHandler(array($response["status"], $response["code"]));
		}
	}

	function requestFriends()
	{
		session_start();
		if(verifySession())
		{
			$uId = $_SESSION['userId'];
			
			$response = getFriends($uId);

			if ($response['status'] === "success") 
			{
				echo json_encode(array('status' => 'success', 'code' => 200 , 'response' => $response['response']));
			} 
			else 
			{
				errorHandler($response["status"], $response["code"]);
			}
		}
		else
		{
			errorHandler('User not logged in', 406);
		}
	}


	/**
	 * Logout the currently logged in user.
	 * Destroys and unsets the session.
	 */
	function attemptLogout()
	{
		session_start();
		if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) 
		{
			session_unset();
			session_destroy();
			echo json_encode(array( 'status' => 'success', 'code' => 200));
		}	
	}

	function verifySession()
	{
		if(empty($_SESSION['userId']) || !isset($_SESSION['userId']) || $_SESSION['userId'] === 'undefined')
		{
		    return false;
		}
		return true;
	}
	
	function errorHandler($status, $code)
	{
		header("HTTP/1.1 $code $status.");
		die("Error detected.");
	}

?>