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
    $returnJson = array('updateShowButtons'=>array(),'updateShowSpinner'=>array(),'updateRemoveButtons'=>array(),'updateRemoveSpinner'=>array());

    $lobbyUserArray = explode("_",$lobbyString);

    //loop through array of all challenges
    $challengeArray = json_decode(getUserChallenges($_SESSION['userID']));

    foreach ($challengeArray as $ind => $currChallenge) {
        //print_r($currChallenge);
        //userIDSend, userIDRec, acceptedYN, challengeID
        //in_array($needle, $haystack)

        //lobby user has sent a challenge to the current user. accepted status is still null and it hasnt timed out
        if ($currChallenge->userIDRec == $_SESSION['userID']){
            if (in_array($currChallenge->userIDSend,$lobbyUserArray)) array_push($returnJson['updateShowButtons'],$currChallenge->userIDSend);
        }
            //Update lobby user to show yes or no button, they should have the challengeID in them for passing


        //
        // //current user has sent a challenge to the lobby user. accepted status is still null and it hasnt timed out
        if ($currChallenge->userIDSend == $_SESSION['userID']){
            if(in_array($currChallenge->userIDRec,$lobbyUserArray)) array_push($returnJson['updateShowSpinner'],$currChallenge->userIDRec);
        }
            //update the lobby user to show a spinner
        //challenge that current user sent to lobby user has been denied or timed out
            //update lobby user that has the spinner to remove it and show standard view. THIS NEEDS ALL OF THE USERS INFO
        //challenge that lobby user sent to current user has been denied or timed out
            //update lobby user to remove yes / no buttons and show standard view. THIS NEEDS ALL OF THE USERS INFO
    }
    // echo "Lobby array: ";
    // print_r($lobbyUserArray);
    // echo "challenge array: ";
    // print_r($challengeArray);
    // foreach ($onlineUserArray as $ind => $user) {
    //
    // }
    //array_push($returnJson['remove'],$value);

    echo json_encode($returnJson);
}
 ?>
