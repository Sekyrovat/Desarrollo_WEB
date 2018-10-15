<?php

	if (isset($_COOKIE['firstName']) && isset($_COOKIE['lastName']) && isset($_COOKIE['userName'])) 
	{
		// We redirect to login.
		die("You have logged out");
	}

?>