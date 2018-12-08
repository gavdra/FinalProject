<?php
require_once("dbInfo.inc");

function getOnlineUsers(){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("SELECT * FROM user WHERE onlineYN = 1")){
            $stmt->execute();
            return returnJson($stmt);
            $stmt->close();
            $conn->close();
        }
        else{
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
    // code...
}

function getUserInfo($userID){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("SELECT * FROM user WHERE userID = ?")){
            $stmt->bind_param("i", intval($userID));
            $stmt->execute();
            return returnJson($stmt);
            $stmt->close();
            $conn->close();
        }
        else{
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}

function getUserChallenges($userID){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("SELECT * FROM challenge WHERE userIDSend = ? OR userIDRec = ?")){
            $stmt->bind_param("ii", intval($userID), intval($userID));
            $stmt->execute();
            return returnJson($stmt);
            $stmt->close();
            $conn->close();
        }
        else{
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}


function getChallengeByUsers($userIDSend,$userIDRec){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("SELECT * FROM challenge WHERE userIDSend = ? AND userIDRec = ?")){
            $stmt->bind_param("ii", intval($userIDSend), intval($userIDRec));
            $stmt->execute();
            return returnJson($stmt);
            $stmt->close();
            $conn->close();
        }
        else{
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}

function getChallengeByID($challengeID){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("SELECT * FROM challenge WHERE challengeID = ?")){
            $stmt->bind_param("i", intval($challengeID));
            $stmt->execute();
            return returnJson($stmt);
            $stmt->close();
            $conn->close();
        }
        else{
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}

function makeChallenge($sendID,$recID){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("INSERT INTO challenge (userIDSend,userIDRec) VALUES (?,?)")){
            $stmt->bind_param("ii", intval($sendID), intval($recID));
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        else{
            //throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}
function removeChallenge($challengeID){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("DELETE from challenge WHERE challengeID = ?")){
            $stmt->bind_param("i", intval($challengeID));
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        else{
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}

function updateAcceptChallenge($challengeID){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("UPDATE challenge SET acceptedYN = 1 WHERE challengeID = ?")){
            $stmt->bind_param("i", intval($challengeID));
            $stmt->execute();
        }
        else{
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}

function makeGameLobby($pOneID,$pTwoID){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("INSERT INTO gameLobby (playerOneID,playerTwoID) VALUES (?,?)")){
            $stmt->bind_param("ii", intval($pOneID),intval($pTwoID));
            $stmt->execute();
        }
        else{
            print_r($stmt);
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}

function initializeUserGameState($lobbyID,$userID,$cardArray){
    //insert into userGameState($lobbyID,$userID,$cardArray[0],$cardArray[1],$cardArray[2],0)
    //print_r()
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("INSERT INTO userGameState (lobbyID,userID,card1,card2,card3,turnYN) VALUES (?,?,?,?,?,0)")){
            $stmt->bind_param("iisss", intval($lobbyID),intval($userID),$cardArray[0],$cardArray[1],$cardArray[2]);
            $stmt->execute();
        }
        else{
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}

function initializeDeckTopCard($lobbyID,$card){
    //insert into gameTopCard()
    //insert into userGameState($lobbyID,$userID,$cardArray[0],$cardArray[1],$cardArray[2],0)
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("INSERT INTO gameTopCard (lobbyID,topCardName) VALUES (?,?)")){
            $stmt->bind_param("is", intval($lobbyID),$card);
            $stmt->execute();
        }
        else{
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}
function addLobbyDeckCard($lobbyID,$card){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("INSERT INTO gameDeckCards (lobbyID,cardName) VALUES (?,?)")){
            $stmt->bind_param("is", intval($lobbyID),$card);
            $stmt->execute();
        }
        else{
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}

function getLobbyIDByPlayers($pOneID,$pTwoID){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("SELECT lobbyID from gameLobby WHERE playerOneID = ? AND playerTwoID = ?")){
            $stmt->bind_param("ii", intval($pOneID),intval($pTwoID));
            $stmt->execute();
            return returnJson($stmt);
        }
        else{
            print_r($stmt);
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
    }
}


function returnJson ($stmt){
	$stmt->execute();
	$stmt->store_result();
 	$meta = $stmt->result_metadata();
    $bindVarsArray = array();
	//using the stmt, get it's metadata (so we can get the name of the name=val pair for the associate array)!
	while ($column = $meta->fetch_field()) {
    	$bindVarsArray[] = &$results[$column->name];
    }
	//bind it!
	call_user_func_array(array($stmt, 'bind_result'), $bindVarsArray);
	//now, go through each row returned,
	while($stmt->fetch()) {
    	$clone = array();
        foreach ($results as $k => $v) {
        	$clone[$k] = $v;
        }
        $data[] = $clone;
    }
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	//MUST change the content-type
	header("Content-Type:text/plain");
	// This will become the response value for the XMLHttpRequest object
    return json_encode($data);
}
?>
