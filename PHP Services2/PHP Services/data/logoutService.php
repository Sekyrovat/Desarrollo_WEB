<?php
	header('Content-type: application/json');
	session_start();

	if (isset($_SESSION['firstName']) && isset($_SESSION['lastName']) && isset($_SESSION['userName'])) 
	{
		// We unset all variables.
		session_unset();
		// We destroy the session.
		session_destroy();
		// We redirect to login.
		header("HTTP/1.1 200 Session has been terminated.");
		die("You have logged out");
	}

?>