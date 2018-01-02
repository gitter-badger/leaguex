/*!
*   LEAGUEX
*   @copyright (C) 2014 fankstribe. All rights reserved.
*   @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*   License: Open source - MIT
*   @link http://www.fankstribe.org 
!*/

var $animsition = $('.animsition');
var transition = 1;

function notifications(){
  
    if($('#notes').length){
        $('.totalntf').remove();        
        var userid = $('input[name="userid"]').val();      
        load_filternote(userid);
        
        $('#selectNotifications').on('change', function(){
            transition = 1; 
            load_filternote(userid);
        });
    }
}

function load_filternote(userid,limit){

    var $elem = $(this);
    var $url = 'javascript:void(0)';
    
    if(transition === 1){
        $animsition.animsition('out', $elem, $url);
    }
    var value = $('#selectNotifications').val();
    $('.notes-list').empty();
    $.ajax({
        url: base + "notifications/notes/filterNotifications",
        type: "POST", 
        async: false,
        data: {value:value, user:userid, limit:limit},
        cache: false,
        success: function(response){
            if(response.success){
                morefilternote = response.morenote;
                $('.notes-list').html('');
                if(morefilternote.more){
                    $(window).on("scroll", function(e) {
                        if ($(window).scrollTop() + $(window).height() > $(document).height() - 60) {
                            $(this).off(e);
                            $(".loadmore").show();
                            transition = 2;
                            setTimeout(function() {
                                load_filternote(morefilternote.id , morefilternote.limit);
                                $(".loadmore").hide();
                            }, 400);
                        }
                    });
                }
                ntf = response.ntf;
                if(!ntf.length){                           
                    $('.no-note-wrap').show();
                }else{
                    $('.no-note-wrap').hide();
                    $.each(ntf, function(){
                        var objectType = ''; 
                        if(this.permissions === 4){
                            objectType = '<span class="text-lt">'+this.object+'</span>';
                        }else{
                            objectType = this.object;
                        }
                        var message = $.sprintf(this.message,objectType);    
                        div =   '<a href="'+this.url+'" class="note-container '+this.bg_read+'">'+
                                    '<div class="note">'+
                                        '<div class="note-text">'+
                                            '<div class="note-description">'+message+'</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="note-icon-container">'+
                                        '<div class="note-icon '+this.bg+'"><i class="material-icons">'+this.icon+'</i></div>'+
                                    '</div>'+
                                    '<div class="note-button-container">'+
                                        '<div class="note-button" note_id="'+this.ntf+'">'+
                                            '<div class="btn btn-fab btn-fab-mini no-shadow no-color-bg"><i class="material-icons '+this.is_read+'"></i></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</a>';                            
                        $('.notes-list').append(div);
                    });
                }
            }
            if(transition === 1){
                $animsition.removeClass('fade-out-down-sm');
                $animsition.animsition('in');
            }
        }
    });
}

function markReadUnread(){
    
    $(document).on('click','.notification', function (){    
        var note_id = $(this).attr("note_id");
            $.ajax({
            type: "POST",
            url: base + "notifications/notes/mark_read",
            data: {id: note_id}
            });
        });
   
    if($('#selectNotifications').length){
        $(document).on('click','.note-container', function (){    
            var note_id = $(this).find('.note-button').attr("note_id");
            var status = $(this).find('.note-button-container i');
            if((status).hasClass('visibility_off')){
                status.toggleClass('visibility_off done');
                $(this).toggleClass('unread read');
                $.ajax({
                    type: "POST",
                    url: base + "notifications/notes/mark_read",
                    data: {id: note_id}
                });
            };
        });

        $(document).on('click','.note-button', function (e){
            e.preventDefault();
            var note_id = $(this).attr("note_id");
            var status = $(this).find('i');
            var bg = $(this).closest('.note-container');
            if((status).hasClass('visibility_off')){
                status.toggleClass('visibility_off done');
                bg.toggleClass('unread read');
                $.ajax({
                    type: "POST",
                    url: base + "notifications/notes/mark_read",
                    data: {id: note_id},          
                    success: function(data){
                        if(data.success){}  
                    }
                });
            }else{
                status.toggleClass('visibility_off done');
                bg.toggleClass('unread read');
                $.ajax({
                    type: "POST",
                    url: base + "notifications/notes/mark_unread",
                    data: {id: note_id},          
                    success: function(data){
                        if(data.success){}  
                    }
                });
            };
            return false;
        });
    }
}

function allReadUnread(){
    if($('#selectNotifications').length){
        $(document).on('click','.markall', function (e){
            e.preventDefault();
            var unread = $('.visibility_off');
            var read = $('.done');
            var bg_unread = $('.note-container.unread');
            var bg_read = $('.note-container.read');
            var check_note = '';
            $.ajax({
                async: false,
                url: base + "notifications/notes/count_unread",
                success: function(response){
                    if(response.success){
                        check_note = response.totalntf;                
                    }  
                }
            });
            if(check_note > 0){
                $(unread).toggleClass('visibility_off done');
                $(bg_unread).toggleClass('unread read');
                $.ajax({
                    url: base + "notifications/notes/mark_all_read",
                    success: function(response){
                        if(response.success){}  
                    }
                }); 
            }else{
                $(read).toggleClass('done visibility_off');
                $(bg_read).toggleClass('unread read');
                $.ajax({
                    url: base + "notifications/notes/mark_all_unread",
                    success: function(response){
                        if(response.success){}  
                    }
                });   
            }
        });
    }
}

/* Widget notifications */

$(document).on('click', '.dropdown-notify', function(){
    if($('html').hasClass('sidebar-chat-opened')){
        $('html').removeClass('sidebar-chat-opened');
    };
    if($('html').hasClass('sidebar-mb-opened')){
        $('html').removeClass('sidebar-mb-opened');
    };
    $('.totalntf').text(''); 
    $('.notification-body').html('');  
        var userid = $(this).find('input[name="user_id"]').val();
        load_widgetnote(userid);
    $('.notification-body').animate({scrollTop: $('.notification-body').position().top - 100}, 400);
    $('.notification-body').niceScroll({
        cursorwidth: '4px',
        cursorborder: '2px',
        cursorcolor: 'trasparent',
        railalign: 'right'
    });
});

var limit = 1; 
function load_widgetnote(userid,limit){
    $("#loadnote").show();
    $.ajax({
        type: "POST", 
        async: false,
        url: base + "notifications/notes/notifications",
        data: {user:userid, limit:limit},
        cache: false,
        success: function(response){
            if(response.success){
                morenote = response.morenote;
                $('.notification-body').html('');
                ntf = response.ntf;                
                if(!ntf.length){                           
                    $('.notification-body-wrap').hide();
                    $('.notification-footer').hide();
                }else{
                    $('.notification-body-wrap').show();
                    $('.notification-footer').show();
                }
                $.each(ntf, function(){
                    var objectType = ''; 
                    if(this.permissions == 4){
                        objectType = '<span class="text-lt">'+this.object+'</span>';
                    }else{
                        objectType = this.object;
                    }
                    div ='<a href="'+this.url+'" class="notification '+this.bg_read+'" note_id="'+this.ntf+'">'+
                            '<div class="notification-icon '+this.bg+'"><i class="material-icons">'+this.icon+'</i></div>'+
                                '<div class="notification-text">'+this.message+'</div>'+
                            '</div>'+
                         '</a>';                            
                    $('.notification-body').append(div);
                }); 
                
                if(morenote.more){
                    $('.notification-body').append(
                        '<div id="load-more-wrap" style="text-align:center">'+
                            '<div id="circleG" style="display:none">'+
                                '<div id="circleG_1" class="circleG"></div>'+
                                '<div id="circleG_2" class="circleG"></div>'+
                                '<div id="circleG_3" class="circleG"></div>'+
                            '</div>'+
                            '<a class="btn btn-xs btn-info" id="loadmore" style="width:100%">'+morentf+' ('+morenote.remaining+')</a>'+
                        '</div>'
                    );
                    $('#loadmore').on('click', function(e){
                        e.stopPropagation();
                        $('#circleG').show();
                        $(this).hide();
                        setTimeout(function() {
                             load_widgetnote(morenote.id , morenote.limit);
                            $('#circleG').hide();
                        }, 1500);    
                    });                    
                }
                $("#loadnote").hide();
            }
        }
    });
}

/* Funtion to trigger the refresh event */

bootNotify();


/* Function to update notifications */
function bootNotify()
{
    refresh = setInterval(function(){ 
        $.ajax({
            type: 'GET',
            url : base + "notifications/notes/updates/",
            async : true,
            cache : false,
            success: function(data){               
                if(data.success){                    
                    note = data.notifications;                                
                    totalntf = data.totalntf;                   
                    $(".totalntf").text(totalntf);
                    $('.ntfcount').empty();
                    if(totalntf == 1){
                        $(".ntfcount").printf(unread,totalntf);}
                    else if(totalntf == 0){
                        $(".ntfcount").printf(allread,totalntf);}                        
                    else
                        {$(".ntfcount").printf(allunread,totalntf);}
                    $.each(note, function() {                       
                        $(".drodown-body .media-list a").click(function () {
                            $.ajax({ type: "POST", url: base + "notification/notification/mark_read", data: {id: this.ntf}});
                            return false;
                        });
                    });                    
                }               
            },
            error : function(XMLHttpRequest, textstatus, error) { 
                console.log(error); 
            }
        });

    }, 11000);
}

/* Init functions  */
$(document).ready(function(){
    notifications();
    markReadUnread();
    allReadUnread();
});