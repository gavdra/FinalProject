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
        <title>In Game</title>
    </head>
    <body>
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
          <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
              <!-- Title -->
              <span class="mdl-layout-title">Thirty-One</span>
              <!-- Add spacer, to align navigation to the right -->
              <div class="mdl-layout-spacer"></div>
              <!-- Navigation. We hide it in small screens. -->
              <nav class="mdl-navigation mdl-layout--large-screen-only">
                  <a class="mdl-navigation__link" href="">Quit Game</a>
              </nav>
              <!-- Right aligned menu below button -->

            </div>
          </header>
          <main class="mdl-layout__content">
            <div class="page-content mdl-grid">
                <div class="mdl-cell mdl-cell--4-col">
                </div>

                <div class="mdl-cell mdl-cell--4-col outline">
                </div>
            </div>
            <div class="chatContainer">
                <ul id="chatList" class="mdl-list">
                    <li class="mdl-list__item mdl-list__item--three-line">
                      <span class="mdl-list__item-primary-content">
                        <span class="chatNameSpan">ButtMuncher1<span class="timestamp">[2:30PM]</span></span>
                        <span class="mdl-list__item-text-body chatMessageSpan">
                            Will Sucks a lot of big butts i cant even believe it its rediculous
                        </span>
                      </span>
                    </li>
                    <li class="mdl-list__item mdl-list__item--three-line">
                      <span class="mdl-list__item-primary-content">
                        <span class="chatNameSpan">ButtMuncher1<span class="timestamp">[2:30PM]</span></span>
                        <span class="mdl-list__item-text-body chatMessageSpan">
                            Will Sucks a lot of big butts i cant even believe it its rediculous
                        </span>
                      </span>
                    </li>
                    <li class="mdl-list__item mdl-list__item--three-line">
                      <span class="mdl-list__item-primary-content">
                        <span class="chatNameSpan">ButtMuncher1<span class="timestamp">[2:30PM]</span></span>
                        <span class="mdl-list__item-text-body chatMessageSpan">
                            Will Sucks a lot of big butts i cant even believe it its rediculous
                        </span>
                      </span>
                    </li>
                    <li class="mdl-list__item mdl-list__item--three-line">
                      <span class="mdl-list__item-primary-content">
                        <span class="chatNameSpan">ButtMuncher1<span class="timestamp">[2:30PM]</span></span>
                        <span class="mdl-list__item-text-body chatMessageSpan">
                            Will Sucks a lot of big butts i cant even believe it its rediculous
                        </span>
                      </span>
                    </li>
                    <li class="mdl-list__item mdl-list__item--three-line">
                      <span class="mdl-list__item-primary-content">
                        <span class="chatNameSpan">ButtMuncher1<span class="timestamp">[2:30PM]</span></span>
                        <span class="mdl-list__item-text-body chatMessageSpan">
                            Will Sucks a lot of big butts i cant even believe it its rediculous
                        </span>
                      </span>
                    </li>
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
