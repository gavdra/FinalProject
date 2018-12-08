<?php
session_start();
include('BizData/lobbyData.php');

function updateLobby($lobbyString){
    //this will just store all online users to check who to remove after
    $allOnlineUserID = array();
    //create array that will become json to send back to javascript
    $returnJson = array('inGame'=>array(),'inLobby'=>array(),'addInLobby'=>array(),'addInGame'=>array(),'remove'=>array());
    //split string so you have an array of each userID currently in the lobby
    $lobbyUserArray = explode("_",$lobbyString);
    //Data layer call to get all online users
    $onlineUserArray = json_decode(getOnlineUsers());
    foreach ($onlineUserArray as $ind => $user) {
        array_push($allOnlineUserID, $user->userID);

        //user is in the lobby and is in game. add ingame class
        if (in_array($user->userID, $lobbyUserArray) && $user->inGameYN ){
            array_push($returnJson['inGame'],$user);
        }

        //in the lobby but not in game. display regular lobby view
        if (in_array($user->userID, $lobbyUserArray) && !$user->inGameYN ){
            array_push($returnJson['inLobby'],$user);
        }


        //not in lobby and not in game. add them to lobby
        if (!in_array($user->userID, $lobbyUserArray) && !$user->inGameYN ){
            array_push($returnJson['addInLobby'],$user);
        }

        //not in lobby and in game.
        if (!in_array($user->userID, $lobbyUserArray) && $user->inGameYN ){
            array_push($returnJson['addInGame'],$user);
        }

    }
    //if they are in the lobby but not online remove them
    foreach (array_diff($lobbyUserArray,$allOnlineUserID) as $key => $value) {
        // code...
        array_push($returnJson['remove'],$value);
    }
    echo json_encode($returnJson);
}

function updateChallenges($lobbyString){
    $returnJson = array('updateShowButtons'=>array(),'updateShowSpinner'=>array(),'updateRemoveButtons'=>array(),'updateRemoveSpinner'=>array(),'challengeID'=>array());

    $lobbyUserArray = explode("_",$lobbyString);

    //loop through array of all challenges
    $challengeArray = json_decode(getUserChallenges($_SESSION['userID']));

    foreach ($challengeArray as $ind => $currChallenge) {
        //print_r($currChallenge);
        //userIDSend, userIDRec, acceptedYN, challengeID
        //in_array($needle, $haystack)

        //lobby user has sent a challenge to the current user. accepted status is still null
        if ($currChallenge->userIDRec == $_SESSION['userID']){
            if (in_array($currChallenge->userIDSend,$lobbyUserArray) && is_null($currChallenge->acceptedYN)){
                array_push($returnJson['updateShowButtons'],array($currChallenge->userIDSend,$currChallenge->challengeID));
            }
            else if (in_array($currChallenge->userIDSend,$lobbyUserArray) && $currChallenge->acceptedYN == 0){
                array_push($returnJson['updateRemoveButtons'],json_decode(getUserInfo($currChallenge->userIDSend)));
            }

        }

        //current user has sent a challenge to the lobby user. accepted status is still null
        if ($currChallenge->userIDSend == $_SESSION['userID']){
            if(in_array($currChallenge->userIDRec,$lobbyUserArray) && is_null($currChallenge->acceptedYN)) array_push($returnJson['updateShowSpinner'],array($currChallenge->userIDRec,$currChallenge->challengeID));
        }
            //update the lobby user to show a spinner
        //challenge that current user sent to lobby user has been denied or timed out
            //update lobby user that has the spinner to remove it and show standard view. THIS NEEDS ALL OF THE USERS INFO
        //challenge that lobby user sent to current user has been denied or timed out
            //update lobby user to remove yes / no buttons and show standard view. THIS NEEDS ALL OF THE USERS INFO
    }

    echo json_encode($returnJson);
}

function sendChallenge($userIDRec){
    makeChallenge($_SESSION['userID'],$userIDRec);
}

function denyChallenge($challengeID){
    $challengeArray = json_decode(getChallengeByID($challengeID));
    $sendID = $challengeArray[0]->userIDSend;
    $recID = $challengeArray[0]->userIDRec;

    if ($_SESSION['userID'] == $sendID) echo json_encode(json_decode(getUserInfo($recID)));
    if ($_SESSION['userID'] == $recID) echo json_encode(json_decode(getUserInfo($sendID)));
    removeChallenge($challengeID);
}

function acceptChallenge($challengeID){
    //create array of 52 cards
    $fullDeckArray = makeFullDeck();
    Shuffle($fullDeckArray);
    $pOneArray = array();
    $pTwoArray = array();
    $cardCount = 0;
    while ($cardCount < 3) {
        //get a random number between 0 the size of the deck.
        //get the index for that card and add it to the card array
        //remove it
        $cardOneInd = rand(0,intval(count($fullDeckArray)-1));
        $pOneArray[]= $fullDeckArray[$cardOneInd];
        unset($fullDeckArray[$cardOneInd]);

        $cardTwoInd = rand(0,intval(count($fullDeckArray)-1));
        $pTwoArray[]= $fullDeckArray[$cardTwoInd];
        unset($fullDeckArray[$cardTwoInd]);

        if ($cardCount == 2){
            $cardThreeInd = rand(0,intval(count($fullDeckArray)-1));
            $topCard = $fullDeckArray[$cardThreeInd];
            unset($fullDeckArray[$cardThreeInd]);
        }
        $cardCount++;
    }
    //update so acceptedYN is 1 for challengeID
    updateAcceptChallenge($challengeID);
    //store both of the users from the challenge.
    $challengeArray = json_decode(getChallengeByID($challengeID));
    //make player1 userIDRec, player 2 userIDSend
    $recID = $challengeArray[0]->userIDRec;
    $sendID = $challengeArray[0]->userIDSend;

    makeGameLobby($recID,$sendID);
    //get the lobbyID from this insert^
    $lobbyID = json_decode(getLobbyIDByPlayers($recID,$sendID))[0]->lobbyID;

    //insert into userGameState(lobbyID,playerID,cardArray)
    initializeUserGameState($lobbyID,$recID,$pOneArray);
    initializeUserGameState($lobbyID,$sendID,$pTwoArray);
    //insert into gameTopCard(lobbyID,topCard)from array at first
    initializeDeckTopCard($lobbyID,$topCard);
    //loop through the rest of the deck array and insert into gameDeckCards(lobbyID,currCard)
    foreach ($fullDeckArray as $currCard) {
        addLobbyDeckCard($lobbyID,$currCard);
    }
    $_SESSION['roomID'] = $lobbyID;
    sleep(1);
    echo json_encode(array("lobby"=>$lobbyID,"p1"=>$recID,"p2"=>$sendID));
}

function getChallengeStatus($lobbyString){
    $returnJson = array('updateRemoveSpinner'=>array(),'updateAddToGame'=>array(),'addGameLobby'=>array());
    $lobbyUserArray = explode("_",$lobbyString);
    $sendUser = $_SESSION['userID'];
    foreach ($lobbyUserArray as $ind => $recUserID) {
        //send user, rec user
        $currChallenge = json_decode(getChallengeByUsers($sendUser,$recUserID))[0];
        $currLobby = json_decode(getLobbyIDByPlayers($recUserID,$sendUser))[0];
        if ($currChallenge->challengeID) {
            //the challenge exists.
            //if status is null do nothing
            //if status is yes then add this user to
            if (is_null($currChallenge->acceptedYN)){}
            if($currChallenge->acceptedYN){
                    array_push($returnJson['updateAddToGame'],$currChallenge);
                    array_push($returnJson['addGameLobby'],$currLobby);
            }
        }
        else {
            array_push($returnJson['updateRemoveSpinner'],json_decode(getUserInfo($recUserID)));
        }
    }

    echo json_encode($returnJson);
}

function makeFullDeck(){
    return array('diamond_1','diamond_2','diamond_3','diamond_4','diamond_5','diamond_6','diamond_7','diamond_8','diamond_9','diamond_10','diamond_jack','diamond_queen','diamond_king',
                 'heart_1','heart_2','heart_3','heart_4','heart_5','heart_6','heart_7','heart_8','heart_9','heart_10','heart_jack','heart_queen','heart_king',
                 'spade_1','spade_2','spade_3','spade_4','spade_5','spade_6','spade_7','spade_8','spade_9','spade_10','spade_jack','spade_queen','spade_king',
                 'club_1','club_2','club_3','club_4','club_5','club_6','club_7','club_8','club_9','club_10','club_jack','club_queen','club_king');
}
 ?>
