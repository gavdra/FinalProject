<?php
require_once("dbInfo.inc");

function loginValSan($postData){
    $sanitizedArray = array();
    foreach ($postData as $key => $value) {
        if ($value != "") {
            $value = filter_var($value, FILTER_SANITIZE_STRING);
            $sanitizedArray[$key] = $value;
        }
    }
    return $sanitizedArray;
}

function createUser($userArray){
    var_dump($userArray);
    $username = $userArray['userName'];
    $password = $userArray['password'];
    $password = password_hash($password,PASSWORD_DEFAULT);

    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("INSERT INTO user (username,password,gamesWon,onlineYN,inGameYN) VALUES (?,?,0,0,0)")){
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            return true;
        }
        else{
            throw new Exception("you done goofed");
        }
    }
    catch(Exception $e){
        echo $e;
        return false;
    }
}

function checkLogin($username,$password){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("SELECT password FROM user WHERE username = ?")){
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($hashedPassword);
            while ($stmt->fetch()) {
                if (password_verify($password,$hashedPassword)){
                    return true;
                }
                else {
                    return false;
                }
            }
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

function getUserID($username){
    global $conn; //mysql connection object from dbInfo
    try{
        if ($stmt = $conn->prepare("SELECT userID FROM user WHERE username = ?")){
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($userID);
            while ($stmt->fetch()) {
                return $userID;
            }
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

 ?>
