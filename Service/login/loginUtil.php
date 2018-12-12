<?php
session_start();
include '../../BizData/loginData.php';

if (isset($_POST["loginButton"])) {
    //TODO: Make loginValSan function
    $validatedPOST = loginValSan($_POST);
    if (checkLogin($validatedPOST['userName'],$validatedPOST['password'])) {
        //combo was correct, send them to homepage
        //TODO: write getUserID(), generic get data function..
        $_SESSION['userID'] = getUserID($validatedPOST['userName']);
        //$_SESSION['userID'] = 1;
        //roomID of 1 is the lobby, this is where they get sent automatically.
        $_SESSION['roomID'] = 1;
        setUserOnlineStatus($_SESSION['userID'],1);
        header("Location: ../../Pages/homePage.php");
    }
    else {
        //combo was wrong, send them back to login
        header("Location: ../../index.php");
    }
}

if (isset($_POST["createAccountButton"])) {
    //create the account then send them back to the login
    $valPost = loginValSan($_POST);
    createUser($valPost);
    header("Location: ../../index.php");
}
?>
