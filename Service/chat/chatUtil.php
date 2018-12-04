<?php
    session_start();
    //get data layer stuff from here
    include('BizData/chatData.php');

    //check Authorizations (sessions)
    //prep data to call data layer stuff
    function sendChat($messageData){
        insertChat($messageData['messageText'],$_SESSION['userID'],$_SESSION['roomID']); //database call to insert chat into DB
    }

    function getChat($lastMessageID){
        $roomID = $_SESSION['roomID'];
        echo getRoomChat($roomID,$lastMessageID);
    }


 ?>
