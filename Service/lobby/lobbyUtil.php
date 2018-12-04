<?php
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
    array_push($returnJson['remove'], array_diff($lobbyUserArray,$allOnlineUserID));

    echo json_encode($returnJson);

    //echo json_encode($returnJson);

    //get all online Players
    // if player is in lobby do nothing
    // if player is in game add id to ingame array
    // if player is not in the lobby add userId,username,gamesWon to add array
    // if player is in lobby but not in online players add id to remove array
}
 ?>
