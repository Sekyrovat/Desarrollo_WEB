<?php

header('Content-type: application/json');

session_start();

require('connect.php');
require ('verifySession.php');

if ($conn->connect_error) 
{
    header('HTTP/1.1 500 Bad connection to Database');
    die("The server is down, we couldn't establish the DB connection");
}
else
{   
    $query = "SELECT pt1.postPosterId, pt1.postText, pt1.postImage, useraccounts.userId, useraccounts.username, useraccounts.userProfilePic FROM (SELECT userposts.postPosterId, userposts.postText, userposts.postImage FROM userposts WHERE userposts.postPosterId = 1 OR userposts.postPosterId = (SELECT user1 FROM friendrelations WHERE (user1 = 1 OR user2 = 1) AND areFriends = 'Y') OR userposts.postPosterId = (SELECT user2 FROM friendrelations WHERE (user1 = 1 OR user2 = 1) AND areFriends = 'Y')) as pt1 INNER JOIN useraccounts ON pt1.postPosterId=useraccounts.userId";

    $stmt = $conn->prepare($query);
    # $stmt->bind_param("iiiii",1,1,1,1,1);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $arrOfPosts = array();
    
        while ($row = mysqli_fetch_assoc($result)) {
            $currentRow = array("posterId" => $row["postPosterId"], "postText" => $row["postText"], "postImage" => $row["postImage"], "posterProfilePic" => $row["userProfilePic"], "posterUserName" => $row["username"]);
            array_push($arrOfPosts, $currentRow);
        }
        mysqli_free_result($result);
        echo json_encode($arrOfPosts);


    } 
    else {
        header('HTTP/1.1 500 Bad connection, retrieval error');
        die("Error: " . mysqli_error($conn));
    }
}
?>