<?php
session_start();
if (!isset($_SESSION['userID'])) header("Location:../index.php");
 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/2.6.6/svg.min.js" charset="utf-8"></script>
        <script src="http://code.jquery.com/jquery-latest.js"></script>

        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-red.min.css" />
        <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

        <script src="../Scripts/lobbyScripts.js" charset="utf-8"></script>
        <script src="../Scripts/gameScripts.js" charset="utf-8"></script>
        <script src="../Scripts/uiHelpers.js" charset="utf-8"></script>
        <link rel="stylesheet" href="../Styles/gameStyle.css">
        <link rel="stylesheet" href="../Styles/style.css">
        <title>In Game</title>
    </head>
    <!-- <body onload="initGetChat();"> -->
    <body onload="initUpdateSession();initCheckTurn();initUpdateCards();initUpdateChat()">
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
          <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
              <!-- Title -->
              <span class="mdl-layout-title">Thirty-One</span>
              <!-- Add spacer, to align navigation to the right -->
              <div class="mdl-layout-spacer"></div>
              <!-- Navigation. We hide it in small screens. -->
              <nav class="mdl-navigation mdl-layout--large-screen-only">
                  <a onclick="initLeaveGame()" class="mdl-navigation__link" href="homePage.php">Quit Game</a>
              </nav>
              <!-- Right aligned menu below button -->

            </div>
          </header>
          <main class="mdl-layout__content">
            <div class="page-content mdl-grid">
                <div class="mdl-cell mdl-cell--1-col"></div>
                <div class="mdl-cell mdl-cell--2-col">
                    <a href="#" class="knockButton">KNOCK</a>
                </div>
                <div class="mdl-cell mdl-cell--2-col">
                    <span id="deckCount">Deck Count: 69</span>
                    <div id="deck"></div>
                    <div id="card1"></div>
                </div>
                <div class="mdl-cell mdl-cell--2-col">
                    <h1 id="waitingMessage">Waiting<div class="mdl-spinner mdl-js-spinner is-active"></div></h1>
                    <div id="topCard"></div>
                    <div id="card2"></div>
                </div>
                <div class="mdl-cell mdl-cell--2-col">
                    <div id="pickedUpCard"></div>
                    <div id="card3"></div>
                </div>
                <div class="mdl-cell mdl-cell--2-col">
                    <h3 id='turnHeader'></h3>
                </div>
            </div>
            <div class="chatContainer" id="inGameChat">
                <ul id="chatList" class="mdl-list">
                </ul>
                <div class="chatInput mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input" type="text" id="chatMessage">
                    <label class="mdl-textfield__label" for="chatMessage">Message Text</label>
                </div>
                <button onclick="initSendChat()" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">send</i></button>
            </div>
                <button type="button" class="mdl-chip" id="chatChip" onclick="displayChat()">
                    <span class="mdl-chip__text">View Chat</span>
                </button>
          </main>
      </div>
        <!-- <h1>login....eventually</h1>
        <h1>sign up....eventually</h1>
        <button onclick="svgTest()" type="button" name="button">click for cards</button>
        <div id="drawing" class=""></div> -->

    </body>
</html>
