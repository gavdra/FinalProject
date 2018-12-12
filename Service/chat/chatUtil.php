<?php
    session_start();
    //get data layer stuff from here
    include('BizData/chatData.php');

    function chatValAndSan($messageText){
        return preg_replace("/[^0-9A-Za-z]+/","",$messageText);
    }
    
    function sendChat($messageData){
        insertChat(chatValAndSan($messageData['messageText']),$_SESSION['userID'],$_SESSION['roomID']); //database call to insert chat into DB
    }

    function getChat($lastMessageID){
        $roomID = $_SESSION['roomID'];
        echo getRoomChat($roomID,$lastMessageID);
    }


 ?>
