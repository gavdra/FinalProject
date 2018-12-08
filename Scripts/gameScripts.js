var cards = ['diamond_1','diamond_2','diamond_3','diamond_4','diamond_5','diamond_6','diamond_7','diamond_8','diamond_9','diamond_10','diamond_jack','diamond_queen','diamond_king',
             'heart_1','heart_2','heart_3','heart_4','heart_5','heart_6','heart_7','heart_8','heart_9','heart_10','heart_jack','heart_queen','heart_king',
             'spade_1','spade_2','spade_3','spade_4','spade_5','spade_6','spade_7','spade_8','spade_9','spade_10','spade_jack','spade_queen','spade_king',
             'club_1','club_2','club_3','club_4','club_5','club_6','club_7','club_8','club_9','club_10','club_jack','club_queen','club_king'];


function initUpdateCards(){

    MyXHR('get',{method:'updateCards',a:'game'}).done(function(json){
        console.log("It worked. cards are: ");
    });

    // var card1 = SVG('card1').size(200,500);
    // card1.use(cards[randomIntFromInterval(0,cards.length)],'../Assets/svg-cards.svg');
    //
    // var card2 = SVG('card2').size(200,500);
    // card2.use(cards[randomIntFromInterval(0,cards.length)],'../Assets/svg-cards.svg');
    //
    // var card3 = SVG('card3').size(200,500);
    // card3.use(cards[randomIntFromInterval(0,cards.length)],'../Assets/svg-cards.svg');
    //
    // var deck = SVG('deck').size(200,500);
    // deck.use('back','../Assets/svg-cards.svg');
    //
    // var topCard = SVG('topCard').size(200,500);
    // topCard.use(cards[randomIntFromInterval(0,cards.length)],'../Assets/svg-cards.svg');



}

function checkTurn(){
}
function randomIntFromInterval(min,max){
    return Math.floor(Math.random()*(max-min+1)+min);
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
