/**
 * Front end call to update lobby
 * This will be on a timer to keep the lobby in sync
 */
function initUpdateLobby(){
    //lobbyString = all user IDs in lobby separated by _
    lobbyString = "";
    $(".challenge").each(function(ind,ele){
        lobbyString += ele.id.split("_")[1]+"_";
    });
    //remove the extra _
    lobbyString = lobbyString.slice(0,-1);
    MyXHR('get',{method:'updateLobby',a:'lobby',data: lobbyString}).done(function(json){
        //create elements for lobby users
        for(const user of json['addInLobby']){
            var newLobbyUser = "<div id='user_"+user['userID']+"' class='challenge mdl-color--primary'>";
            newLobbyUser += "<span class='challengeTxt challengeName'>"+user['username']+"</span>";
            newLobbyUser += "<span class='challengeTxt'>Wins: "+user['gamesWon']+"</span>";
            newLobbyUser += "<button onclick='initSendChallenge("+user['userID']+")' class='mdl-button mdl-js-button' type='button' name='button'>CHALLENGE</button></div>";
            $(".challengeContainer").append(newLobbyUser);
        }
        //create elements for in game users
        for(const user of json['addInGame']){
            var newGameUser = "<div id='user_"+user['userID']+"' class='challenge mdl-color--primary inGame'>";
            newGameUser += "<span class='challengeTxt challengeName'>"+user['username']+"</span>";
            newGameUser += "<span class='challengeTxt'>Wins: "+user['gamesWon']+"</span>";
            newGameUser += "<button onclick='initSendChallenge("+user['userID']+")'class='mdl-button mdl-js-button' type='button' name='button' disabled>IN GAME</button></div>";
            $(".challengeContainer").append(newGameUser);
        }
        //find all users in the lobby to make sure they are styled correctly
        for(const user of json['inLobby']){
            //get the element by name
            var lobbyEle = $("#user_"+user['userID']);
            //make sure the ingame class is removed
            $(lobbyEle).removeClass('inGame');
            //make sure the button looks right.
            //May have to add and remove an onclick from this for challenge sending purposes
            $(lobbyEle).children().closest('button').text("CHALLENGE").removeAttr('disabled');
        }
        //find all users in the lobby who are in game to make sure they are styled correctly
        for(const user of json['inGame']){
            //get the element by name
            var lobbyEle = $("#user_"+user['userID']);
            //if inGame class does not exist, add it
            if (!$(lobbyEle).hasClass('inGame')){
                $(lobbyEle).addClass('inGame');
            }
            //change button text to say IN GAME. if disabled class does not exist, add it
            if (!$(lobbyEle).children().closest('button').text("IN GAME").is(':disabled')){
                $(lobbyEle).children().closest('button').prop('disabled',true);
            }
        }

        for (var i = 0; i < json['remove'].length; i++) {
            var currID = json['remove'][i];
            $("#user_"+currID).remove();
        }
    });
    initUpdateChallenges();
    setTimeout('initUpdateLobby()',10000); //keeping this for future ref to put at bottom of getChat
}

//begin the series of challenges being searched for
function initUpdateChallenges(){
    //lobbyString = all user IDs in lobby separated by _
    lobbyString = "";
    $(".challenge").each(function(ind,ele){
        lobbyString += ele.id.split("_")[1]+"_";
    });
    //remove the extra _
    lobbyString = lobbyString.slice(0,-1);

    MyXHR('get',{method:'updateChallenges',a:'lobby',data: lobbyString}).done(function(json){
        for (var i = 0; i < json['updateShowButtons'].length; i++) {
            userID = json['updateShowButtons'][i][0];//this is the userID
            challengeID = json['updateShowButtons'][i][1];//this is the challengeID to put into the button elements
            lobbyEle = $("#user_"+userID);
            $(lobbyEle).find('button').remove();
            $($(lobbyEle).find('span')[1]).html("Has Challenged you!");
            $(lobbyEle).find('.mdl-spinner').remove();
            $(lobbyEle).find('.adButtons').remove();
            $(lobbyEle).append("<div class='adButtons'> <button onclick='initAcceptChallenge("+challengeID+",this)' class='mdl-button mdl-js-button mdl-button--icon'><i class='material-icons'>done</i></button><button onclick='initDenyChallenge("+challengeID+",this)' class='mdl-button mdl-js-button mdl-button--icon'><i class='material-icons'>not_interested</i></button></div>");
        }

        for (var i = 0; i < json['updateShowSpinner'].length; i++) {
            userID = json['updateShowSpinner'][i][0];//this is the userID
            challengeID = json['updateShowSpinner'][i][1];//this is the challengeID to put into the button elements
            lobbyEle = $("#user_"+userID);
            $(lobbyEle).find('button').remove();
            $($(lobbyEle).find('span')[1]).html("Awaiting response");
            $(lobbyEle).find('.mdl-spinner').remove();
            $(lobbyEle).append("<div class='mdl-spinner mdl-js-spinner is-active'></div>");
            componentHandler.upgradeDom();
        }
        checkChallengeStatus();
   });
}

function initSendChallenge(userToChallenge){
    console.log("here");
    MyXHR('post',{method:'sendChallenge',a:'lobby',data: userToChallenge}).done(function(json){});
}

function initDenyChallenge(challengeID,ele){
    MyXHR('post',{method:'denyChallenge',a:'lobby',data: challengeID}).done(function(json){
        $($(ele).parent().parent().find('span')[1]).html('Wins: '+ json[0]['gamesWon']);
        $(ele).parent().parent().append("<button onclick='initSendChallenge("+json[0]['userID']+")' class='mdl-button mdl-js-button' type='button' name='button'>CHALLENGE</button></div>");
        $(ele).parent().remove();
    });
}

function initAcceptChallenge(challengeID,ele){
    MyXHR('post',{method:'acceptChallenge',a:'lobby',data: challengeID}).done(function(json){
        window.location.href = "inGame.php?lobbyID="+json['lobby']+"&p1="+json['p1']+"&p2="+json['p2'];
        //after everything has been put into the database redirect to ingame.php?lobbyID=json['lobby']&p1=json['p1']&p2=json['p2']
    });

}

function checkChallengeStatus(){
    lobbyString = "";
    $('div').find('.mdl-spinner').parent().each(function(i,ele){
        lobbyString += ele.id.split("_")[1]+"_";
    });
    lobbyString = lobbyString.slice(0,-1);

    MyXHR('get',{method:'getChallengeStatus',a:'lobby',data:lobbyString}).done(function(json){

        //for each user in this list update UI back to normal
        //DO this before checking other list so it updates before sending them to a game
        for (var i = 0; i < json['updateRemoveSpinner'].length; i++) {
            if (json['updateRemoveSpinner'][i] != null){
                userID = json['updateRemoveSpinner'][i][0]['userID'];
                gamesWon = json['updateRemoveSpinner'][i][0]['gamesWon'];
                lobbyEle = $("#user_"+userID);
                $($(lobbyEle).find('span')[1]).html('Wins: '+ gamesWon);
                $(lobbyEle).find('.mdl-spinner').remove();
                $(lobbyEle).append("<button onclick='initSendChallenge("+userID+")' class='mdl-button mdl-js-button' type='button' name='button'>CHALLENGE</button></div>");
            }
        }



        //If this is populated then a game has been accepted. It contains just the userID of the person who accepted the game
        //call a function to add the current user to a lobby
        //Find the lobby ID by checking against the user from json
        if(json['updateAddToGame'][0] != null){
            if(json['updateAddToGame'][0]['acceptedYN']){
                setTimeout(function(){
                    window.location.href = "inGame.php?lobbyID="+json['addGameLobby'][0]['lobbyID']+"&p1="+json['updateAddToGame'][0]['userIDRec']+"&p2="+json['updateAddToGame'][0]['userIDSend'];
                },3000);
            }
        }
    });

}


/**
 * Front end call for sendChat
 * Not sure if this should call getChat()
 */
function initSendChat(){
    chatParams = {messageText: $("#chatMessage").val()}
    //chatParams = {messageText: "message"};
    MyXHR('post',{method:'sendChat',a:'chat',data: chatParams}).done(function(json){
        //call getChat explicitly so they dont have to wait 2 seconds to see their message send.
        //clear message box
       // setTimeout('getChat()',2000); keeping this for future ref to put at bottom of getChat
   }).always(function(){
       $("#chatMessage").val("");
       initGetChat(true);
   });
}


function initGetChat(called=false) {
    lastChatID = $("#chatList").find("li").last().attr('id');
    MyXHR('get',{method:'getChat',a:'chat',data: lastChatID}).done(function(json){
        if (json){
            for (i = 0; i < json.length; i++){
                var messageTimestamp = new Date(json[i]['timestamp']);
                var hours24 = messageTimestamp.getHours();
                var tod = hours24 > 12 ? 'PM' : 'AM';
                var hours12 = hours24 > 12 ? hours24 - 12 : hours24;
                var minutes = messageTimestamp.getMinutes() + tod;

                var eleString = "<li id='"+json[i]['messageID']+"' class='mdl-list__item mdl-list__item--three-line chatHeightMax'>" ;
                eleString += "<span class='mdl-list__item-primary-content chatHeightMax'>" ;
                eleString += "<span class='chatNameSpan'>"+json[i]['username']+"<span class='timestamp'>"+"["+hours12+":"+minutes+"]</span></span>" ;
                eleString += "<span class='mdl-list__item-text-body chatMessageSpan'>" ;
                eleString += json[i]['messageText'];
                eleString += "</span></span></li><hr>" ;
                $("#chatList").append(eleString);
            }
        }
        if (!called){
            setTimeout('initGetChat()',2000); //keeping this for future ref to put at bottom of getChat
        }
    });
}

function MyXHR(getPost,d){
   //ajax shortcut
   return $.ajax({
       type: getPost,
       async: true,
       cache: false,
       url:'../mid.php',
       data:d,
       dataType:'json',
       beforeSend:function(){
           //turn on spinner if I have one

       }
   }).always(function(){
       //always do this
   }).fail(function(err){
       console.log(err);
   });
}
//MVC (data flow generally goes CMV. c is javascript)
//model is data
//Controller interacts with the model
//Model interacts with view


//SOA
//mid.php = facilitator of functions ?
//Service, business, data
//Service = Security, prep data
//business= Authorization
