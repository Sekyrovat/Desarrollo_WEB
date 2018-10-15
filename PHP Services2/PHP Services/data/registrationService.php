<?php
    header('Accept: application/json');
    header('Content-type: application/json');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "TestDB";

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) 
    {
        header('HTTP/1.1 500 Bad connection to Database');
        die("The server is down, we couldn't establish the DB connection");
    }
    else
    {
        $userName = $_POST['username'];
        
        $sql = "SELECT username 
                FROM Users 
                WHERE username = '$userName'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            header('HTTP/1.1 409 Conflict, Username already in use please select another one');
            die("Username already in use.");
        }
        else
        {
            $userPassword = $_POST['userPassword'];
            $userFirstName = $_POST['userFirstName'];
            $userLastName = $_POST['userLastName'];
            
            $sql = "INSERT INTO Users (fName, lName, username, passwrd) 
                    VALUES ('$userFirstName', '$userLastName', '$userName', '$userPassword')";
            
            if (mysqli_query($conn, $sql)) 
            {
                $response = array("status" => "success");
                echo json_encode($response);
            } 
            else 
            {
                header('HTTP/1.1 500 Bad connection, something went wrong while saving your data, please try again later');
                die("Error: " . $sql . "\n" . mysqli_error($conn));
            }
        }
    } 

?>

