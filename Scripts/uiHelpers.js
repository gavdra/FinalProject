function displayChat(){
    //slide toggle to display hidden div
    //Scrolltop to scroll div to the bottom
    $(".chatContainer").slideToggle("fast").scrollTop($('.chatContainer')[0].scrollHeight);
}

function scrollHomepageChat(){
    setTimeout(function(){$(".homepageChat").scrollTop($('.homepageChat')[0].scrollHeight);}, 100);
}
