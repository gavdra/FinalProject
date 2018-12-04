
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

/**
 * Front end call to update lobby
 * This will be on a timer to keep the lobby in sync
 */
function initUpdateLobby(){
    //lobbyString = all user IDs in lobby separated by _
    lobbyString = "";
    $(".challenge").each(function(i,ele){
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
            newLobbyUser += "<button class='mdl-button mdl-js-button' type='button' name='button'>CHALLENGE</button></div>";
            $(".challengeContainer").append(newLobbyUser);
        }
        //create elements for in game users
        for(const user of json['addInGame']){
            var newGameUser = "<div id='user_"+user['userID']+"' class='challenge mdl-color--primary inGame'>";
            newGameUser += "<span class='challengeTxt challengeName'>"+user['username']+"</span>";
            newGameUser += "<span class='challengeTxt'>Wins: "+user['gamesWon']+"</span>";
            newGameUser += "<button class='mdl-button mdl-js-button' type='button' name='button' disabled>IN GAME</button></div>";
            $(".challengeContainer").append(newGameUser);
        }
        //
        for(const user of json['inLobby']){
            //get the element by name
            var lobbyEle = $("#user_"+user['userID']);
            //make sure the ingame class is removed
            $(lobbyEle).removeClass('inGame');
            //make sure the button looks right.
            //May have to add and remove an onclick from this for challenge sending purposes
            console.log($(lobbyEle).children().closest('button').text("CHALLENGE").removeAttr('disabled'));
        }
        //
        for(const user of json['inGame']){
            //get the element by name
            var lobbyEle = $("#user_"+user['userID']);
            //if inGame class does not exist, add it
            if (!$(lobbyEle).hasClass('inGame')){
                $(lobbyEle).addClass('inGame');
            }

            if (!$(lobbyEle).children().closest('button').text("IN GAME").is(':disabled')){
                $(lobbyEle).children().closest('button').prop('disabled',true);
            }
            //change button text to say IN GAME. if disabled class does not exist, add it
        }
    });
    //setTimeout('initUpdateLobby()',2000); //keeping this for future ref to put at bottom of getChat
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
