<?php
    
    //Stating what are we going to recive in our scenarios. And what we are going to send.
        // A json in this case for both.
    header('Accept: application/json');
    header('Content-type: application/json');

    ///////
    // Connection Section Begin
    ///////
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "TestDB";

    $conn = new mysqli($servername, $username, $password, $dbname);
    ///////
    // Connection Section End
    ///////
    
    if ($conn->connect_error) 
    {
        header('HTTP/1.1 500 Bad connection to Database');
        die("The server is down, we couldn't establish the DB connection");
    }
    else
    {
        //Verify we are in the same content.
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') 
        {
            parse_str(file_get_contents("php://input"), $delete_vars);
            
            // Put vars will hold the information of all the variables it contains.

            $userName = $delete_vars["userName"];
            $currentPassword = password_hash($delete_vars["currentPassword"], PASSWORD_DEFAULT);


            //The above code shows us that the json we send to the backend and that we will receive must look
            //similar to the following

            $sql = "SELECT *
                    FROM users
                    WHERE username = '$userName' AND passwrd = '$currentPassword'";

            $result = $conn->query($sql);

            if ($result ->num_rows > 0) 
            {
                $sql = "DELETE FROM users
                        WHERE username = '$userName' AND passwrd = '$currentPassword'";

                //Other method returns a string.
                //if ($conn->query($sql) == 'TRUE')
                //The mysqli_query returns a boolean.
                if (mysqli_query($conn, $sql))
                {
                    $response = array('message' => "User Deleted");
                    echo json_encode($response);
                } else
                {
                    header('HTTP/1.1 500 Something went wrong in the update of data. Please try again later.');
                    //Here we retrieve the exact error that happened.
                    //DONT LEAVE THIS TYPE OF ERROR RESPONSE ON AN ACTUAL WEB APPLICATION.
                    die("Error :". $sql . "\n" . mysqli_error($conn));
                }
            } 
            else
            {
                header('HTTP/1.1 406 User not found');
                die("I can't delete the user.");
            }
        } 
        else 
        {   
            //We got here since the protocols dont match.
            header('HTTP/1.1 400 Bad Request');
            die("Bad request done. Are you trying something fishy?");
        }
        
    }
?>