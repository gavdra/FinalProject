<?php
    //get data layer stuff from here
    include('BizData/chatData.php');

    //check Authorizations (sessions)
    //prep data to call data layer stuff
    function sendChat($messageData){
        var_dump($messageData);
        insertChat($messageData['messageText'],$messageData['userID'],$messageData['roomID']); //database call to insert chat into DB
    }

    function getChat($getParams){
        $roomID = $getParams['roomID'];
        echo getRoomChat($roomID);
    }


 ?>
