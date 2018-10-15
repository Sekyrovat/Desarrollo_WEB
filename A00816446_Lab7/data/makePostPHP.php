<?php

header('Accept: application/json');
header('Content-type: application/json');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weblab";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) 
{
    header('HTTP/1.1 500 Bad connection to Database');
    die("The server is down, we couldn't establish the DB connection");
}
else
{
    session_start();

    $userId = $_SESSION['userId'];

    $query = "INSERT INTO userposts (postPosterId, postText, postImage) 
        VALUES (:postPosterId, :postText, :postImage)";

    $prepared_stmt = $conn->prepare($query);
    $prepared_stmt->bindParam(':postPosterId',$userId);
    $prepared_stmt->bindParam(':postText',$_POST['postText']);
    $prepared_stmt->bindParam(':postImage',$_POST['postImage']);

    if ($prepared_stmt->execute()) 
    {
        $response = array("status" => "success");
        echo json_encode($response);
    }
    else 
    {
        header('HTTP/1.1 500 Conflict, something went wrong, try again later.');
        die("Service unreacheable.");
    }
}