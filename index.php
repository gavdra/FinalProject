<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/2.6.6/svg.min.js" charset="utf-8"></script>
        <script src="http://code.jquery.com/jquery-latest.js"></script>

        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-red.min.css" />
        <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

        <script src="Scripts/dataXferHelpers.js" charset="utf-8"></script>
        <script src="Scripts/svgHelpers.js" charset="utf-8"></script>
        <script src="Scripts/uiHelpers.js" charset="utf-8"></script>
        <link rel="stylesheet" href="Styles/style.css">
        <title>Login</title>
    </head>
    <body>
        <div class="mdl-layout mdl-js-layout mdl-color--grey-100">
        	<main class="mdl-layout__content">
                <div id="loginContainer">
                    <div class="mdl-card mdl-shadow--6dp center">
                                  <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
                                      <h2 class="mdl-card__title-text">Thirty-One</h2>
                                  </div>
                        <form action="Service/login/loginUtil.php" method="post" autocomplete="off">
                            <div class="mdl-card__supporting-text">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                      <input required name="userName" class="mdl-textfield__input" type="text" id="username" autocomplete="off">
                                      <label class="mdl-textfield__label" for="username">Username</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                      <input required name="password" class="mdl-textfield__input" type="password" id="password" autocomplete="new-password">
                                      <label class="mdl-textfield__label" for="password">Password</label>
                                    </div>
                            </div>
                            <div class="mdl-card__actions mdl-card--border">
                                <button type="submit" name="loginButton" class="mdl-button mdl-js-button mdl-button--raised">Login</button>
                                <button type="button" class="mdl-button mdl-js-button mdl-button right"><a href="./Pages/createAccount.php">Create Account</a></button>
                            </form>
                            </div>
                    </div>
                </div>
        	</main>
        </div>
      </div>
    </body>
</html>
