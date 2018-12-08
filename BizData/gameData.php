<?php
require_once("dbInfo.inc");

function getUserCardsByLobby($lobbyID,$userID){

	global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("SELECT * FROM userGameState WHERE userID = ? AND lobbyID = ?")){
            $stmt->bind_param("ii", intval($userID), intval($lobbyID));
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

function getTopCardByLobby($lobbyID){
	global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("SELECT * FROM gameTopCard WHERE lobbyID = ?")){
            $stmt->bind_param("i",intval($lobbyID));
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

function getGameStateByLobby($lobbyID){
	global $conn; //mysql connection object from dbInfo
	try{
		if ($stmt = $conn->prepare("SELECT * FROM userGameState WHERE lobbyID = ?")){
			$stmt->bind_param("i",intval($lobbyID));
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

//make it so it is this players turn.
function updateLobbyTurn($lobbyID,$userID){
	global $conn; //mysql connection object from dbInfo
	try{
		if ($stmt = $conn->prepare("UPDATE userGameState SET turnYN = 1 WHERE lobbyID = ? AND userID = ?")){
			$stmt->bind_param("ii",intval($lobbyID),intval($userID));
			$stmt->execute();
			$stmt->close();
		}
		else{
			throw new Exception("you done goofed");
		}
	}
	catch(Exception $e){
		echo $e;
	}

	try{
		if ($stmt = $conn->prepare("UPDATE userGameState SET turnYN = 0 WHERE lobbyID = ? AND userID = ?")){
			$stmt->bind_param("ii",intval($lobbyID),intval(getOtherLobbyUser($lobbyID,$userID)));
			$stmt->execute();
			$stmt->close();
		}
		else{
			throw new Exception("you done goofed");
		}
	}
	catch(Exception $e){
		echo $e;
	}
}

function getOtherLobbyUser($lobbyID,$userID){
	global $conn; //mysql connection object from dbInfo
	try{
		if ($stmt = $conn->prepare("SELECT userID FROM userGameState WHERE lobbyID = ? AND userID != ?")){
			$stmt->bind_param("ii",intval($lobbyID),intval($userID));
			return json_decode(returnJson($stmt))[0]->userID;
			$stmt->close();
		}
		else{
			throw new Exception("you done goofed");
		}
	}
	catch(Exception $e){
		echo $e;
	}
}

//stmt with all params already bound (or no params at all)
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
