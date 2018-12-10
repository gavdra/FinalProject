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
    }

    function pickupTopCard(){
        $lobbyID = $_SESSION['roomID'];
        $userID = $_SESSION['userID'];
        //get the top card for the lobby
        $topCard = json_decode(getTopCardByLobby($lobbyID))[0]->topCardName;
        //update the current user 4th card to be the top card
        if (setPickedUpCard($lobbyID,$userID,$topCard)) {
            echo json_encode(array('findDiscard'));
        };
    }
    function drawFromDB(){
        $lobbyID = $_SESSION['roomID'];
        $userID = $_SESSION['userID'];

        //get all of the cards for this lobbyid in an array
        //find a random number between 0 and the count of the array - 1
        //$cardArray[$randomNumber] = 'card_name'
        //update the current user 4th card to be the card name
        //delete from the deck using lobbyID and 'card_name'

    }

    function checkScore(){
        $lobbyID = $_SESSION['roomID'];
        $userID = $_SESSION['userID'];
        //get the 3 cards for the player
        //$heartVal, $diamondVal, $spadeVal, $clubVal = 0
        //foreach card{
            //split card on _
            //$suit = split[0]
            //$val = split[1]
            //the value is not a digit (jack,queen,king)
            //if (!ctype_digit($val)) $val = 10
            //if ($val == 1) $val += 10
            //if ($suit == 'heart') $heartVal += $val
            //if ($suit == 'diamond') $diamondVal += $val
            //if ($suit == 'spade') $spadeVal += $val
            //if ($suit == 'club') $clubVal += $val
        //
        //}
        //return max($heartVal, $diamondVal, $spadeVal, $clubVal)

    }

    function replaceCard($cardNum){
        $lobbyID = $_SESSION['roomID'];
        $userID = $_SESSION['userID'];
        //get all of the cards for the current user in the current lobby
        $cardArray = json_decode(getUserCardsByLobby($lobbyID,$userID));


        $cardName = "card$cardNum";
        $discardCard = $cardArray[0]->$cardName;
        $pickedUpCard = $cardArray[0]->pickedUpCard;
        //store the 4th card
        //store the cardNum card
        //update the user card1,card2, or card3 to be the 4th card
        //update the 4th card to be null again
        updateCard($lobbyID,$userID,$cardNum,$pickedUpCard);
        //update the top card to be the cardNum card
        updateTopCard($lobbyID,$discardCard);
        endTurn($lobbyID,$userID);
    }



 ?>
