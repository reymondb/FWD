function clickgame(title,host,start_date,start_time,description,gamephoto,booklink,spotsleft,doneornot)
{
    //console.log(title+" , "+host+" , "+start_date+" , "+start_time+" , "+description+" , "+gamephoto+" , "+booklink);
    $("#title").html(title);
    $("#host").html(host);
    $("#start_date").html(start_date);
    $("#start_time").html(start_time);
    $("#description").html(description);
    $("#gamephoto").css('background-image',"url("+gamephoto+")");
    $("#booklink").attr("href", "/book/"+booklink);
    if(spotsleft <= 0 || doneornot == 1){
        $(".checker").hide();
        $(".err_mess").show();
        
    }
    else{
        $(".checker").show();
        
        $(".err_mess").hide();
    }
}
function shareFb(text){
    window.open(
        'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href)+'&quote='+text, 
        'facebook-share-dialog', 
        'width=626,height=436'); 
        return false;
}
function shareTwitter(text){
    window.open(
        'https://twitter.com/share?url='+encodeURIComponent(document.URL)+'&text='+text,
        'facebook-share-dialog', 
        'width=626,height=436'); 
        return false;
}
function shareLinkedIn(text){
    window.open(
        'https://www.linkedin.com/sharing/share-offsite?url='+encodeURIComponent(document.URL)+'&comment='+text,
        'facebook-share-dialog', 
        'width=626,height=436'); 
        return false;
}