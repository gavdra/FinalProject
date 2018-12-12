function initUpdateSession(){
    if(document.location.toString().indexOf('?') !== -1) {
        lobbyID = document.location.toString().split('?')[1].split('&')[0].split("=")[1];
    }
    MyXHR('get',{method:'updateSession',a:'game',data:lobbyID}).done(function(json){});
}

function initLeaveGame(){
    MyXHR('get',{method:'leaveGame',a:'game'}).done(function(json){});

}

function initUpdateCards(){
    MyXHR('get',{method:'updateCardUI',a:'game'}).done(function(json){
        $("#card1").empty();
        var card1 = SVG('card1').size(200,500);
        card1.use(json['card1'],'../Assets/svg-cards.svg');

        $("#card2").empty();
        var card2 = SVG('card2').size(200,500);
        card2.use(json['card2'],'../Assets/svg-cards.svg');

        $("#card3").empty();
        var card3 = SVG('card3').size(200,500);
        card3.use(json['card3'],'../Assets/svg-cards.svg');

        $("#topCard").empty();
        var topCard = SVG('topCard').size(200,500);
        topCard.use(json['topCard'],'../Assets/svg-cards.svg');

        //$('#deckCount').html("Deck Count: " + json['deckCount']);
        $('#deckCount').html("Deck Count: " + 12);
    });
}

function initCheckTurn(){
    MyXHR('get',{method:'checkTurn',a:'game'}).done(function(json){
        if (json['gameOver']){
            $(".page-content").empty();
            //empty the entire page content div
            if (json['winLoss']) {
                $(".page-content").append("<h1>YOU WIN</h1>");
                $(".page-content").append("<h4>You had "+json['score']+" points</h4>");
                console.log("YOU WIN ");
                console.log(json['score']);
            }
            else {
                $(".page-content").append("<h1>YOU LOSE</h1>");
                $(".page-content").append("<h4>You had "+json['score']+" points</h4>");
            }
            //put a message sayng you json['winloss'] with json['score']
        }
        else{
            if (json['turnYN']){
                initUpdateCards();
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
                $('#topCard').attr('onClick','pickupTopCard()');
                $('#deck').attr('onClick','drawFromDB()');
                $('.knockButton').attr('onClick','knock()');

            }

            if (!json['turnYN']){
                initUpdateCards();
                $('#turnHeader').html('Other Players Turn');
                $('#topCard').removeAttr('onclick');
                $('#deck').removeAttr('onclick');
                $('#card1').removeAttr('onclick');
                $('#card2').removeAttr('onclick');
                $('#card3').removeAttr('onclick');
            }
        }

    });

    setTimeout(function(){initCheckTurn();},1000);
}

function pickupTopCard(){
    console.log("pick that shit up");
    MyXHR('post',{method:'pickupTopCard',a:'game'}).done(function(json){
        console.log("here");
        //all DB stuff is done to put the top card into the intermediate spot.
        //add an onlick for card1,card2,card3.
        $('#card1').attr('onClick',"replaceCard('1')");
        $('#card2').attr('onClick',"replaceCard('2')");
        $('#card3').attr('onClick',"replaceCard('3')");
    });

}
function drawFromDB(){
    console.log("drawing a card from the DB");
    MyXHR('post',{method:'drawFromDB',a:'game'}).done(function(json){

        //make sure the spot to display is empty but showing
        $("#pickedUpCard").empty();
        $("#pickedUpCard").show();
        //add the card to the spot
        var pickedUpCard = SVG('pickedUpCard').size(200,500);
        pickedUpCard.use(json[0],'../Assets/svg-cards.svg');
        // card was chosen from deck and put into the 4th spot.
        // give other cards functionality
        $('#card1').attr('onClick',"replaceCard('1')");
        $('#card2').attr('onClick',"replaceCard('2')");
        $('#card3').attr('onClick',"replaceCard('3')");
        $("#card3").addClass('cardAbove');
    });
}

function replaceCard(cardNum){
    //this function will update the clicked card to be the picked up card
    //it also ends their turn
    MyXHR('post',{method:'replaceCard',a:'game',data: cardNum}).done(function(json){
        $("#card3").removeClass('cardAbove');
        $("#pickedUpCard").empty();
        $("#pickedUpCard").hide();

    });
}

function knock(){
    //this will knock and end the the players turn
    MyXHR('post',{method:'knock',a:'game'}).done(function(json){
        // $("#card3").removeClass('cardAbove');
        // $("#pickedUpCard").empty();
        // $("#pickedUpCard").hide();

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
