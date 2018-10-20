<?php
	// At the top of the page check to see whether the user is logged in or not
    if(empty($_SESSION['userId']))
    {
        // If they are not, redirect them to the login page.
        header("Location: ./index.html");
        
        // Remember that this die statement is absolutely critical.  Without it,
        // people can view your members-only content without logging in.
        die("Redirecting to login.php");
    }
?>