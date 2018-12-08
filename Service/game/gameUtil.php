<?php
    session_start();
    //get data layer stuff from here
    include('BizData/gameData.php');

    //check Authorizations (sessions)
    //prep data to call data layer stuff
    function updateCards(){
        $returnJson = array('card1' => '','card2' => '','card3' => '','topCard' => '' );
        //getCards($_SESSION['rooomID'],$_SESSION['userID']);
        getCards($_SESSION['roomID'],$_SESSION['userID']);
        //insertChat($messageData['messageText'],$_SESSION['userID'],$_SESSION['roomID']); //database call to insert chat into DB
        //
        echo json_encode($returnJson);

    }

 ?>
