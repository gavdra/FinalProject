
/**
 * Front end call for sendChat
 * Not sure if this should call getChat()
 */
function initSendChat(){
    //chatParams = {messageText: $("#chatMessage").val(, roomID: 1, userID: 69}
    chatParams = {messageText: "message", roomID: 1, userID: 69};
    MyXHR('post',{method:'sendChat',a:'chat',data: chatParams}).done(function(json){
        //call getChat explicitly so they dont have to wait 2 seconds to see their message send.
        //clear message box

       // setTimeout('getChat()',2000); keeping this for future ref to put at bottom of getChat
    });
}

/**
 * Front end call to update lobby
 * This will be on a timer to keep the lobby in sync
 */
function initUpdateLobby(){
    //lobbyString = all user IDs in lobby separated by _
    lobbyString = "1_2_3_4_69";
    MyXHR('get',{method:'updateLobby',a:'lobby',data: lobbyString}).done(function(json){
        console.log("it worked");
        console.log(json);
        //JSON= {add:, delete:, inGame:}

        //call getChat explicitly so they dont have to wait 2 seconds to see their message send.
        //clear message box

    });
    //setTimeout('initUpdateLobby()',2000); //keeping this for future ref to put at bottom of getChat
}

function getChat() {
    chatParams = {roomID: 1}
    MyXHR('get',{method:'getChat',a:'chat',data: chatParams}).done(function(json){
        //append to UL WITH THE ID chatList
        //              <li class="mdl-list__item mdl-list__item--three-line">
        var eleString = "<li class='mdl-list__item mdl-list__item--three-line chatHeightMax'>" ;
        //               <span class="mdl-list__item-primary-content">
        eleString += "<span class='mdl-list__item-primary-content chatHeightMax'>" ;
        //               <span class="chatNameSpan">ButtMuncher1<span class="timestamp">[2:30PM]</span></span>
        eleString += "<span class='chatNameSpan'>"+"ButtMuncher1"+"<span class='timestamp'>"+"[2:30PM]"+"</span></span>" ;
        //                        <span class="mdl-list__item-text-body chatMessageSpan">
        eleString += "<span class='mdl-list__item-text-body chatMessageSpan'>" ;
        //                            Will Sucks a lot of big butts i cant even believe it its rediculous
        eleString += "chat Message Here admfbakdfba fa sf ashdjf asdf hasd fasdh fajs dfkashd fkjahd fkahdkfahjdfka dfkh";
        //                        </span>
        //                      </span>
        //                    </li>
        eleString += "</span></span></li>" ;
        $("#chatList").append(eleString);
        $("#chatList").append(eleString);
        //call getChat explicitly so they dont have to wait 2 seconds to see their message send.
        //clear message box
        console.log(json);
       //   setTimeout('getChat()',2000); //keeping this for future ref to put at bottom of getChat
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
