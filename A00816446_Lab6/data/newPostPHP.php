<?php
header('Accept: application/json');
header('Content-type: application/json');

require('connect.php');

#session_start();
#$uId = $_SESSION['userId'];

if ($conn->connect_error) 
{
    header('HTTP/1.1 500 Bad connection to Database');
    die("The server is down, we couldn't establish the DB connection");
}
else
{   

    $query = "INSERT INTO userposts (postImage, postPosterId, postText) VALUES (?, 1, ?)";
    $stmt = $conn->prepare($query);
    
    $stmt->bind_param("ss", $postImage, $postText);
    
    $userId = $_POST['userId'];
    if ($_POST['newImage'] == NULL) {
        $postImage = "";
    }
    else{
        $postImage = $_POST['newInput'];
    }

    if ($_POST['newInput'] == NULL) {
        $postText = "";
    }
    else{
        $postText = $_POST['newInput'];
    }
    if ($stmt->execute()) 
    {
        $response = array("status" => "success");
        echo json_encode($response);
    }
    else {
        header('HTTP/1.1 500 Bad connection, post error');
        die("Error: " . mysqli_error($conn));
    }
}
?>