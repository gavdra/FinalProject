<?php
    session_start();
    //get data layer stuff from here
    include('BizData/gameData.php');

    //check Authorizations (sessions)
    //prep data to call data layer stuff
    function updateCardUI(){
        $userCards = json_decode(getUserCardsByLobby($_SESSION['roomID'],$_SESSION['userID']));
        $topCard = json_decode(getTopCardByLobby($_SESSION['roomID']));
        $deckArray = json_decode(getDeckByLobby($_SESSION['roomID']));
        $returnJson = array('card1' => $userCards[0]->card1,'card2' => $userCards[0]->card2,'card3' => $userCards[0]->card3,'topCard' => $topCard[0]->topCardName, 'deckCount'=> count($deckArray));
        echo json_encode($returnJson);
    }

    function updateSession($lobbyID){
        $_SESSION['roomID']=$lobbyID;
        //make in game status true
        updateUserInGame($_SESSION['userID'],1);
    }

    function leaveGame(){
        //make in game status = 0;
        deleteGameLobby($_SESSION['roomID']);
        updateUserInGame($_SESSION['userID'],0);
        $_SESSION['roomID']=1;
        //header("Location:../Pages/homePage.php");
    }

    function checkScore($cardArray){
        //get the 3 cards for the player
        $heartVal = 0;
        $diamondVal = 0;
        $spadeVal = 0;
        $clubVal = 0;

        foreach ($cardArray as $card) {
            $splitCard = explode("_",$card);
            $suit = $splitCard[0];
            $val = $splitCard[1];
            //the value is not a digit (jack,queen,king) make it 10
            if (!ctype_digit($val)) $val = 10;
            //if the value is 1 thats an ace. make val 11
            if ($val == 1) $val = 11;
            if ($suit == 'heart') $heartVal += $val;
            if ($suit == 'diamond') $diamondVal += $val;
            if ($suit == 'spade') $spadeVal += $val;
            if ($suit == 'club') $clubVal += $val;
        }
        return max($heartVal, $diamondVal, $spadeVal, $clubVal);
    }
    function checkTurn(){
        //select * from userGameState for this lobby
        $lobbyID = $_SESSION['roomID'];
        $stateArray = json_decode(getGameStateByLobby($lobbyID));
        //player 1 turn = 0 knock = 1
        //player 2 turn = 1 knock = 0

        //neither players turn. update lobby so it is someone
        if (!$stateArray[0]->turnYN && !$stateArray[1]->turnYN) updateLobbyTurn($lobbyID,$stateArray[0]->userID);

        //Knock is true and its my turn. the game is over
        if($stateArray[0]->turnYN && $stateArray[1]->knockYN){
            //get the score for both users
            $player1Cards = array($stateArray[0]->card1,$stateArray[0]->card2,$stateArray[0]->card3);
            $player2Cards = array($stateArray[1]->card1,$stateArray[1]->card2,$stateArray[1]->card3);

            $p1Score = checkScore($player1Cards);
            $p2Score = checkScore($player2Cards);

            if ($stateArray[0]->userID == $_SESSION['userID']) {
                echo json_encode(array('gameOver' => 1,'score'=> $p1Score, 'winLoss' => $p1Score > $p2Score));
            }
            else {
                echo json_encode(array('gameOver' => 1,'score'=> $p2Score, 'winLoss' => $p1Score < $p2Score));
            }

            //($stateArray[0]->userID == $_SESSION['userID'])

        }
        else{
            foreach ($stateArray as $currState) {
                if ($currState->userID == $_SESSION['userID'] && $currState->turnYN){
                    echo json_encode(array('turnYN' => 1));
                }

                if ($currState->userID != $_SESSION['userID'] && $currState->turnYN){
                    echo json_encode(array('turnYN' => 0));
                }

            }
        }
    }


    function pickupTopCard(){
        $lobbyID = $_SESSION['roomID'];
        $userID = $_SESSION['userID'];
        //get the top card for the lobby
        $topCard = json_decode(getTopCardByLobby($lobbyID))[0]->topCardName;
        //update the current user 4th card to be the top card
        if (setPickedUpCard($lobbyID,$userID,$topCard)) {
            echo json_encode(array('got the top card'));
        };
    }
    function drawFromDB(){
        $lobbyID = $_SESSION['roomID'];
        $userID = $_SESSION['userID'];

        $deckArray = json_decode(getDeckByLobby($lobbyID));
        $maxInd = intval(count($deckArray) - 1);
        $pickUpInd = rand(0,$maxInd);
        $pickedUpCard = $deckArray[$pickUpInd];

        if (setPickedUpCard($lobbyID,$userID,$pickedUpCard->cardName)) {
            removeCardFromDeck($lobbyID,$pickedUpCard->cardName);
            echo json_encode(array($pickedUpCard->cardName));
        };

        //get all of the cards for this lobbyid in an array
        //find a random number between 0 and the count of the array - 1
        //$cardArray[$randomNumber] = 'card_name'
        //update the current user 4th card to be the card name
        //delete from the deck using lobbyID and 'card_name'

    }


    function knock(){
        $lobbyID = $_SESSION['roomID'];
        $userID = $_SESSION['userID'];

        updateUserKnock($lobbyID,$userID);
        endTurn($lobbyID,$userID);
    }

    function replaceCard($cardNum){
        $lobbyID = $_SESSION['roomID'];
        $userID = $_SESSION['userID'];
        //get all of the cards for the current user in the current lobby
        $cardArray = json_decode(getUserCardsByLobby($lobbyID,$userID));


        $cardName = "card$cardNum";
        $discardCard = $cardArray[0]->$cardName;
        $pickedUpCard = $cardArray[0]->pickedUpCard;

        //replace the discarded card with the picked up card
        updateCard($lobbyID,$userID,$cardNum,$pickedUpCard);
        updateTopCard($lobbyID,$discardCard);
        if (checkOtherPlayerKnock($lobbyID,$userID)) {
            updateUserKnock($lobbyID,$userID);
            makeOtherPlayersTurn($lobbyID,$userID);
        }
        else {
            endTurn($lobbyID,$userID);
        }
        echo json_encode(array('Card Replaced'));
    }



 ?>
