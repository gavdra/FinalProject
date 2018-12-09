function initUpdateSession(){
    if(document.location.toString().indexOf('?') !== -1) {
        lobbyID = document.location.toString().split('?')[1].split('&')[0].split("=")[1];
    }
    MyXHR('get',{method:'updateSession',a:'game',data:lobbyID}).done(function(json){});
}

function initUpdateCards(){
    MyXHR('get',{method:'updateCardUI',a:'game'}).done(function(json){
        var card1 = SVG('card1').size(200,500);
        card1.use(json['card1'],'../Assets/svg-cards.svg');

        var card2 = SVG('card2').size(200,500);
        card2.use(json['card2'],'../Assets/svg-cards.svg');

        var card3 = SVG('card3').size(200,500);
        card3.use(json['card3'],'../Assets/svg-cards.svg');

        var topCard = SVG('topCard').size(200,500);
        topCard.use(json['topCard'],'../Assets/svg-cards.svg');

        //$('#deckCount').html("Deck Count: " + json['deckCount']);
        $('#deckCount').html("Deck Count: " + 12);
    });
}

function initCheckTurn(){
    MyXHR('get',{method:'checkTurn',a:'game'}).done(function(json){
        if (json['turnYN']){
            //initUpdateCards()
            //update page to say its your turn
            $('#turnHeader').html('Your Turn');
            //if it is still showing the waiting Message remove it and show the cards
            if (!$("#waitingMessage").is(":hidden")) {
                $('#waitingMessage').hide();
                $('#deckCount').show();
                $('#deck').show();
                $('#card1').show();
                $('#card2').show();
                $('#card3').show();
                $('#topCard').show();
                var deck = SVG('deck').size(200,500);
                deck.use('back','../Assets/svg-cards.svg');
            }

            //give cards functionality
            //$('#topCard').attr('onClick','pickupTopCard()');
            //$('#deck').attr('onClick','drawFromDB()');
            //$('.knockButton').attr('onClick','knock()');

        }

        if (!json['turnYN']){
            $('#turnHeader').html('Other Players Turn');
            //$('.knockButton').attr('onclick');
            //$('#topCard').removeAttr('onclick');
            //$('#deck').removeAttr('onclick');


        }
    });
}

function pickupTopCard(){
    //MyXHR('post',{method:'pickupTopCard',a:'game'}).done(function(json){
        //all DB stuff is done to put the top card into the intermediate spot.
        //add an onlick for card1,card2,card3.
            //$('#card1').attr('onClick','replaceCard('1')');
            //$('#card2').attr('onClick','replaceCard('2')');
            //$('#card3').attr('onClick','replaceCard('3')');
    //});

}
function drawFromDB(){
    //MyXHR('post',{method:'drawFromDB',a:'game'}).done(function(json){
        //card was chosen from deck and put into the 4th spot.
        //add an onlick for card1,card2,card3.
            //$('#card1').attr('onClick','replaceCard('1')');
            //$('#card2').attr('onClick','replaceCard('2')');
            //$('#card3').attr('onClick','replaceCard('3')');
    //});

}

function replaceCard(cardNum){
    //MyXHR('post',{method:'replaceCard',a:'game',data: cardNum}).done(function(json){
        //all DB stuff is done to replace the clicked card
        //thier turn is done.
            //$('.knockButton').attr('onclick');
            //$('#topCard').removeAttr('onclick');
            //$('#deck').removeAttr('onclick');
        //call function to make it the next players turn
        //call initUpdateCards
    //});

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
