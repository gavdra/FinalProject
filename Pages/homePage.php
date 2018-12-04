<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/2.6.6/svg.min.js" charset="utf-8"></script>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-red.min.css" />
        <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

        <script src="../Scripts/dataXferHelpers.js" charset="utf-8"></script>
        <script src="../Scripts/svgHelpers.js" charset="utf-8"></script>
        <script src="../Scripts/uiHelpers.js" charset="utf-8"></script>
        <link rel="stylesheet" href="../Styles/style.css">
        <title>Home Page</title>
    </head>
    <body onload="initGetChat();scrollHomepageChat();">
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
          <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
              <!-- Title -->
              <span class="mdl-layout-title">Thirty-One</span>
              <!-- Add spacer, to align navigation to the right -->
              <div class="mdl-layout-spacer"></div>
              <!-- Navigation. We hide it in small screens. -->
              <nav class="mdl-navigation">
                  <a class="mdl-navigation__link" href="">Home</a>
                  <a class="mdl-navigation__link" href="">My Account</a>
                  <a class="mdl-navigation__link" href="../index.php">Logout</a>
              </nav>
            </div>
          </header>
          <main class="mdl-layout__content">
            <div class="page-content mdl-grid">
                <div class="mdl-cell mdl-cell--6-col">
                    <h1>Lobby</h1>
                    <div class="challengeContainer">
                        <div id="user_1" class="challenge mdl-color--primary">
                            <span class="challengeTxt challengeName">FuckBoi69</span>
                            <span class="challengeTxt">Wins: 69</span>
                            <button class= "mdl-button mdl-js-button" type="button" name="button">CHALLENGE</button>
                        </div>
                        <div id="user_2" class="challenge mdl-color--primary">
                            <span class="challengeTxt challengeName">PoopMaster420</span>
                            <span class="challengeTxt">Wins: 69</span>
                            <div class="mdl-spinner mdl-js-spinner is-active"></div>
                        </div>
                        <div id="user_3" class="challenge mdl-color--primary">
                            <span class="challengeTxt challengeName">SneakySpider710</span>
                            <span class="challengeTxt">Has Challenged You</span>
                            <div class="adButtons">
                                <button class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">done</i></button>
                                <button class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">not_interested</i></button>
                            </div>
                        </div>
                        <div id="user_4" class="challenge mdl-color--primary inGame">
                            <span class="challengeTxt challengeName">ButtMuncher42</span>
                            <span class="challengeTxt">Wins: 69</span>
                            <button class= "mdl-button mdl-js-button" type="button" name="button" disabled>IN GAME</button>
                        </div>
                    </div>
                </div>

                <div class="mdl-cell mdl-cell--6-col">
                    <h1>Chat</h1>
                    <div class="homepageChat">
                        <ul id="chatList" class="mdl-list">
                        </ul>
                        <div class="chatInput mdl-textfield mdl-js-textfield">
                            <input onclick="scrollHomepageChat()" class="mdl-textfield__input darkerTB" type="text" id="chatMessage">
                            <label class="mdl-textfield__label darkerTBL" for="chatMessage">Message Text</label>
                        </div>
                        <button onclick="initSendChat()" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">send</i></button>
                    </div>
                </div>
            </div>
          </main>
      </div>
        <!-- <h1>login....eventually</h1>
        <h1>sign up....eventually</h1>
        <button onclick="svgTest()" type="button" name="button">click for cards</button>
        <div id="drawing" class=""></div> -->

    </body>
</html>
