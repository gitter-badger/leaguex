/*!
*   LEAGUEX
*   @copyright (C) 2014 fankstribe. All rights reserved.
*   @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*   License: Open source - MIT
*   @link http://www.fankstribe.org 
!*/

/* Funtion to trigger the refresh event */

bootChat();

/* Function to display individual chatbox */

$(document).on('click', '[data-toggle="show-chat"]', function(){
    user = $(this).find('input[name="user_id"]').val();
    $('.media-list-bubble').empty();        
    $(this).find('span[rel="'+user+'"]').text('');       
    load_thread(user);   
    $('.viewport .chat-container').niceScroll({cursorwidth: '4px',
        cursorborder: '0px',
        cursorcolor: 'trasparent',
        railalign: 'right',
        horizrailenabled:true
    });        
});

/* Remove total icon messages unread from header */

$(document).on('click', '#sidebarChat', function(){
    $('.totalmsg').text('');      
});

/* Function to send message */

$(document).on('keypress', '.input-chat input', function(e){
    var txtarea = $(this);
    var message = txtarea.val();
    if(message !== "" && e.which == 13){
        txtarea.val('');
        // save the message 
        $.ajax({
            type: "POST",
            url: base  + "chat/chat/save_message",
            data: {message: message, user : user},
            cache: false,
            success: function(response){
                msg = response.message;
                li ='<li class="media '+ msg.type +'">'+
                        '<a href="javascript:void(0);" class="media-object" title="'+ msg.name +'"><img class="img-circle" src= "'+base+'assets/img/avatars/'+msg.avatar+'"></a>'+
                        '<div class="media-body">'+
                            '<p class="media-text">'+msg.body+'</p>'+
                            '<span class="clearfix"></span>'+
                            '<p class="media-meta">'+msg.time+'</p>'+
                        '</div>'+
                    '</li>';                    
                $('.media-list-bubble').append(li);  
                $('.chat-container').animate({scrollTop: $('.chat-container').prop("scrollHeight")}, 500);
            }
        });
    }
});

/* Function to load messages */

function bootChat(){
    refresh = setInterval(function(){ 
        $.ajax({
            type: 'GET',
            url : base + "chat/chat/updates/",
            async : true,
            cache : false,
            success: function(data){               
                if(data.success){                    
                    thread = data.messages;
                    senders = data.senders;                   
                    totalmsg = data.totalmsg;
                    if ($('.sidebar-chat-opened').length){}
                    else{
                    $(".totalmsg").text(totalmsg); 
                    }
                    $.each(thread, function() {                        
                        chatbuddy = $("#chat_buddy_id").val();
                        if(this.sender == chatbuddy){
                            li ='<li class="media media-left '+ this.type +'">'+
                                    '<a href="javascript:void(0);" class="media-object" title="'+ this.name +'"><img class="img-circle" src= "'+base+'assets/img/avatars/'+this.avatar+'"></a>'+
                                    '<div class="media-body">'+
                                        '<p class="media-text">'+this.body+'</p>'+
                                        '<span class="clearfix"></span>'+
                                        '<p class="media-meta">'+this.time+'</p>'+
                                    '</div>'+
                                '</li>';                                   
                            $('.media-list-bubble').append(li);   
                            $('.chat-container').animate({scrollTop: $('.chat-container').prop("scrollHeight")}, 800);
                            //Mark this message as read
                            $.ajax({ type: "POST", url: base + "chat/chat/mark_read", data: {id: this.msg}});
                        } else {
                            from = this.sender;
                            $.each(senders, function() {
                                if(this.user == from){
                                    $(".media-list-contact").find('span[rel="'+from+'"]').text(this.count);                                           
                                }
                            });
                        }                       
                    });
                    var audio = new Audio(base +"assets/notify/notify.mp3").play();
                }               
            },
            error : function(XMLHttpRequest, textstatus, error) { 
                console.log(error); 
            }
        });
    }, 2000);
}

/* Function to load threaded messages or user conversation */
var limit = 1;
var user = $(this).find('input[name="user_id"]').val();
function load_thread(user,limit){
    //send an ajax request to get the user conversation 
    $.ajax({
        type: "POST",
        url: base  + "chat/chat/messages", 
        data: {user:user, limit:limit},
        cache: false,
        success: function(response){
            if(response.success){            
                buddy = response.buddy;
                var buddyname = ''; 
                if(buddy.permissions == 4){
                    buddyname = '<span class="text-lt">'+buddy.name+'</span>';
                } else {
                    buddyname = buddy.name;
                }
                var buddyavatar = '<img class="img-circle" src= "'+base+'assets/img/avatars/'+buddy.avatar+'">'
                $('#chat_buddy_id').val(buddy.id);
                $('.conversation-title').html(buddyname);
                $('.conversation-status').html(buddyavatar);
                $('.media-list-bubble').html('');
                if(buddy.more){
                    $('.media-list-bubble').append(
                        '<div id="load-more-wrap" style="text-align: center; margin-bottom: 10px;">'+
                            '<span class="more-message" id="moremessage">'+moremsg+' ('+buddy.remaining+')</span>'+
                        '</div>'
                    );
                    $('#moremessage').on('click', function(){
                        load_thread(buddy.id, buddy.limit);
                        if(!buddy.more){
                            $(this).parent().hide();
                        }
                    });                      
                }      
                thread = response.thread;
                $.each(thread, function() {
                    li ='<li class="media media-left '+ this.type +'">'+
                            '<a href="javascript:void(0);" class="media-object" title="'+ this.name +'"><img class="img-circle" src= "'+base+'assets/img/avatars/'+this.avatar+'"></a>'+
                            '<div class="media-body">'+
                                '<p class="media-text">'+this.body+'</p>'+
                                '<span class="clearfix"></span>'+
                                '<p class="media-meta">'+this.time+'</p>'+
                            '</div>'+
                        '</li>';  
                    $('.media-list-bubble').append(li);    
                });
                if(buddy.scroll){
                    $('.chat-container').animate({scrollTop: $('.chat-container').prop("scrollHeight")}, 800);
                }
            }
        }
    });
}