<?php
	// We dont need to connect to the DB since what we are going to do is verify the session.
	header('Content-type: application/json');
	// As of now we don't really need to accept something.
	// header('Accept: application/json');

	// We open the session.
	// We are going to ask if the variables are set, this will help us validate that the user
	// is not trying to skip important steps.
	// If you close the browser the session automatically destroys.
	session_start();

	if (isset($_SESSION['firstName']) && isset($_SESSION['lastName']) && isset($_SESSION['userName'])) 
	{
		// We echo back the variables.
		$response = array("fName" => $_SESSION['firstName'], "lName" => $_SESSION['lastName'], "user" => $_SESSION['userName']);

		echo json_encode($response);
	} 
	else 
	{
		// In case the info is not loaded we destroy the session, generate an error report,
		// and redirect the user to a page.
		session_destroy();
		header("HTTP/1.1 406 Session not set yet");
		die("Your session has expired");
	}

?>