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
		case 'PUT':
			# code...
			break;
		case 'POST':
			# code...
			break;
		default:
			# code...
			break;
	}


	function getRequests($action)
	{
		switch ($action) 
		{
			case 'LOGIN':
				# Here we call the login from the data layer.
				requestLogin();
				break;
			case 'GET_INFO':
				# Here we call the login from the data layer.
				requestInfo();
				break;
			default:
				# code...
				break;
		}
	}

	function requestLogin()
	{
		$uName = $_GET['userName'];
		$pwd = $_GET['userPassword'];

		$conditionHandler = userName_exits($uName);

		if ($conditionHandler["code"] === 200) 
		{
			$response = attemptLogin($uName, $pwd);
			if ($response['status'] === "Success") 
			{
				session_start();
	        	$_SESSION['userId'] = $response['response'];

				setcookie("userName",$uName,time()+600);

				echo json_encode($response["response"]);
			} 
			else 
			{
				errorHandler($response["status"], $response["code"]);
			}
		} 
		else 
		{
			errorHandler($conditionHandler["status"], $conditionHandler["code"]);
		}
	}

	function requestInfo()
	{
		$conditionHandler = getProfileInfo($_SESSION['userId']);
	}

	function errorHandler($status, $code)
	{
		# We use a switch since by the end of developing you will have a lot of different status.
		switch ($code) {
			case 406:
				header("HTTP/1.1 $code User $status");
				die("Wrong credentials provided.");
				break;
			case 409:
				header("HTTP/1.1 $code User $status");
				die("Wrong credentials provided");
				break;
			case 500:
				header("HTTP/1.1 $code $status. Bad connection, portal is down.");
				die("The server is down, we couldn't retrieve the info.");
				break;
			default:
				# code...
				break;
		}
	}
?>