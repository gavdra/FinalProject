<?php
    session_start();
    //get data layer stuff from here
    include('BizData/gameData.php');

    //check Authorizations (sessions)
    //prep data to call data layer stuff
    function updateCards(){
        $userCards = json_decode(getUserCardsByLobby($_SESSION['roomID'],$_SESSION['userID']));
        $topCard = json_decode(getTopCardByLobby($_SESSION['roomID']));
        $returnJson = array('card1' => $userCards[0]->card1,'card2' => $userCards[0]->card2,'card3' => $userCards[0]->card3,'topCard' => $topCard[0]->topCardName );
        echo json_encode($returnJson);
    }

 ?>
