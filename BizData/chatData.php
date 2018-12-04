<?php
require_once("dbInfo.inc");


function insertChat($messageText,$userID,$roomID){
	global $conn; //mysql connection object from dbInfo
	try{
		if ($stmt = $conn->prepare("INSERT INTO chat (userID,roomID,messageText) VALUES (?,?,?)")){
			$stmt->bind_param("iis", intval($userID), intval($roomID), $messageText);
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

function getRoomChat($roomID,$lastMessageID){
	global $conn; //mysql connection object from dbInfo
	try{
		//select roomID,messageID,messageText,timestamp,username from chat join user on chat.userID = user.userID
		if ($stmt = $conn->prepare("SELECT C.roomID,C.messageID,C.messageText,C.timestamp,U.username FROM chat C join user U on C.userID = U.userID where C.roomID = ? && C.messageID > ?")){
			$stmt->bind_param("ii", intval($roomID),intval($lastMessageID));
			echo returnJson($stmt);
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
