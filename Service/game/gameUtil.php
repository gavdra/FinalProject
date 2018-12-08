<?php
    session_start();
    //get data layer stuff from here
    include('BizData/gameData.php');

    //check Authorizations (sessions)
    //prep data to call data layer stuff
    function updateCardUI(){
        $userCards = json_decode(getUserCardsByLobby($_SESSION['roomID'],$_SESSION['userID']));
        $topCard = json_decode(getTopCardByLobby($_SESSION['roomID']));
        $returnJson = array('card1' => $userCards[0]->card1,'card2' => $userCards[0]->card2,'card3' => $userCards[0]->card3,'topCard' => $topCard[0]->topCardName );
        echo json_encode($returnJson);
    }

    function updateSession($lobbyID){
        $_SESSION['roomID']=$lobbyID;
    }

    function checkTurn(){

        //select * from userGameState for this lobby
        $lobbyID = $_SESSION['roomID'];
        $stateArray = json_decode(getGameStateByLobby($lobbyID));

        //neither players turn. update lobby so it is someone
        if (!$stateArray[0]->turnYN && !$stateArray[1]->turnYN) updateLobbyTurn($lobbyID,$stateArray[0]->userID);

        foreach ($stateArray as $currState) {
            if ($currState->userID == $_SESSION['userID'] && $currState->turnYN) echo json_encode(array('turnYN' => 1));

            if ($currState->userID != $_SESSION['userID'] && $currState->turnYN) echo json_encode(array('turnYN' => 0));

        }

        //for each
            //if userID == $_SESSION['userID']. the current state is for this user
                //if turnYN = 1
                //(and player 2 is still in game)
                //some check for knocking (eventually)
                    //send back it is this players turn. update the cards to be clickable
                    //echo json_encode(array('turnYN' => 1));
            //if userID != $_SESSION['userID']. the current state is not for this user
                //if turnYN = 1
                    // It is not this users turn. update the onclicks to be gone
                    //echo json_encode(array('turnYN' => 0));
            //if it is neither of their turn
                //make a DB query to update so it is player 1 turn

    }

 ?>
