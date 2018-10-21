<?php
	if (isset($_SESSION['firstName']) && isset($_SESSION['lastName']) && isset($_SESSION['userName'])) 
	{

		header("location : './index.html'")
		die("You have logged out");
	}

?>