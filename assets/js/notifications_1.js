/*!
*   LEAGUEX
*   @copyright (C) 2014 fankstribe. All rights reserved.
*   @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*   License: Open source - MIT
*   @link http://www.fankstribe.org 
!*/

var $animsition = $('.animsition');
$(window).on('load', function() {
    $animsition.each(function(i){
        $(this).animsition('in');
    });
 });
var test = 1
function notifications(){
    
    if($('#notes').length){
        var userid = $('input[name="userid"]').val();      
        load_filternote(userid);
    }
    
     if($('#selectNotifications').length){
        $('#selectNotifications').on('change', function(){
            test = 1; 
            load_filternote(userid);
            
        });
    }
}



function load_filternote(userid,limit){
    
    var $elem = $(this);
    var $url = 'javascript:void(0)';
    if(test === 1){
    $animsition.animsition('out', $elem, $url);
    }
    var value = $('#selectNotifications').val();
    $('.notes-list').empty();
    $.ajax({
        url: base + "notifications/notes/filterNotifications",
        type: "POST", 
        data: {value:value, user:userid, limit:limit},
        success: function(response){
            if(response.success){
                morefilternote = response.morenote;
                $('.notes-list').html('');
                if(morefilternote.more){
                    $(window).scroll(function(){
                        if($(window).scrollTop() + $(window).height() >= $(document).height()){
                            $(".loadmore").show();
                            test = 2;
                            load_filternote(morefilternote.id , morefilternote.limit);
                            $(".loadmore").hide();
                        }
                    return false;
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
                        div = '<a href="'+this.url+'" class="note-container '+this.bg_read+'">\
                               <div class="note">\
                               <div class="note-text">\
                               <div class="note-description">'+message+'</div>\
                               </div>\
                               </div>\
                               <div class="note-icon-container">\
                               <div class="note-icon '+this.bg+'"><i class="material-icons">'+this.icon+'</i></div>\
                               </div>\
                               <div class="note-button-container">\
                               <div class="note-button" note_id="'+this.ntf+'">\
                               <div class="btn btn-fab btn-fab-mini no-shadow no-color-bg"><i class="material-icons '+this.is_read+'"></i></div>\
                               </div>\
                               </div>\
                               </a>';                            
                        $('.notes-list').append(div);
                    });
                }
            }
             if(test === 1){
            $animsition.removeClass('fade-out-down-sm');
            $animsition.animsition('in');
        }
       
        }
    });
}

var limit = 1; 
function load_pagenote(userid,limit){
    var checkpage = '0';
   
    $.ajax({
        type: "POST", 
        url: base + "notifications/notes/notifications",
        data: {user:userid, limit:limit, checkpage:checkpage},
        cache: false,
        success: function(response){
            if(response.success){
                morenote = response.morenote;
                $('.notes-list').html('');
                if(morenote.more){
                    $(window).scroll(function(){
                        if($(window).scrollTop() + $(window).height() >= $(document).height()){
                            $(".loadmore").show();
                            load_pagenote(morenote.id , morenote.limit);
                            $(".loadmore").hide();
                        }
                    return false;
                    });
                }
                
                ntf = response.ntf; 
                if(!ntf.length){                           
                    $('.no-note-wrap').show();
                }else{
                    $('.no-note-wrap').hide();
                    $.each(ntf, function(){
                        list ='<a href="'+this.url+'" class="note-container '+this.bg_read+'">\
                              <div class="note">\
                              <div class="note-text">\
                              <div class="note-description">'+this.message+'</div>\
                              </div>\
                              <div class="note-icon-container">\
                              <div class="note-icon '+this.bg+'"><i class="material-icons">'+this.icon+'</i></div>\
                              </div>\
                              <div class="note-button-container">\
                              <div class="note-button" note_id="'+this.ntf+'">\
                              <div class="btn btn-fab btn-fab-mini no-shadow no-color-bg"><i class="material-icons '+this.is_read+'"></i></div>\
                              </div>\
                              </div>\
                              </div>\
                              </a>';                            
                        $('.notes-list').append(list);
                    }); 
               
                }
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
                        if(data.success){
                            totalntf = data.totalntf;
                            $('.ntfcount').contents().filter(function(){
                                return this.nodeType===3;
                            }).remove();
                            if(totalntf == 1){
                                $(".ntfcount").printf(unread,totalntf);}
                            else if(totalntf == 0){
                                $(".ntfcount").printf(allread,totalntf);}                        
                            else{
                                $(".ntfcount").printf(allunread,totalntf);
                            }
                        }  
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
                        if(data.success){
                            totalntf = data.totalntf;
                            $('.ntfcount').contents().filter(function(){
                                return this.nodeType===3;
                            }).remove();
                            if(totalntf == 1){
                                $(".ntfcount").printf(unread,totalntf);}
                            else if(totalntf == 0){
                                $(".ntfcount").printf(allread,totalntf);}                        
                            else{
                                $(".ntfcount").printf(allunread,totalntf);
                            }
                        }  
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
                        if(response.success){
                            var totalntf = response.totalntf;
                            $('.ntfcount').empty();
                            if(totalntf == 1){
                                $(".ntfcount").printf(unread,totalntf);
                            }
                            else if(totalntf == 0){
                            $(".ntfcount").printf(allread,totalntf);
                            }                        
                            else{
                            $(".ntfcount").printf(allunread,totalntf);
                            }
                        }  
                    }
                }); 
            }else{
                $(read).toggleClass('done visibility_off');
                $(bg_read).toggleClass('unread read');
                $.ajax({
                    url: base + "notifications/notes/mark_all_unread",
                    success: function(response){
                        if(response.success){
                            var totalntf = response.totalntf;
                            $('.ntfcount').empty();
                            if(totalntf == 1){
                                $(".ntfcount").printf(unread,totalntf);
                            }
                            else if(totalntf == 0){
                                $(".ntfcount").printf(allread,totalntf);
                            }                        
                            else{
                                $(".ntfcount").printf(allunread,totalntf);
                            }
                        }  
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
    if($('html').hasClass('notification-sidebar-opened')){
        $('html').removeClass('notification-sidebar-opened');
    }else{
        $('html').addClass('notification-sidebar-opened');
        $('.totalntf').text(''); 
        $('.notification-sidebar-body').html('');  
        var userid = $(this).find('input[name="user_id"]').val();
        load_widgetnote(userid);
    }
    var heightContainer = $('.notification-sidebar-container').outerHeight()- 60;
    $('.notification-sidebar-body').height(heightContainer).niceScroll({
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
        url: base + "notifications/notes/notifications",
        data: {user:userid, limit:limit},
        cache: false,
        success: function(response){
            if(response.success){
                morenote = response.morenote;
                $('.notification-sidebar-body').html('');
                if(morenote.more){
                    $('.notification-sidebar-body').scroll(function(){
                        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                            $("#loadnote").show();
                            setTimeout(function(){
                            load_widgetnote(morenote.id , morenote.limit);
                            }, 5000);
                            $("#loadnote").hide();
                        }
                        return false;
                    });
                }
                ntf = response.ntf;                
                $.each(ntf, function(){
                    var objectType = ''; 
                    if(this.permissions == 4){
                        objectType = '<span class="text-lt">'+this.object+'</span>';
                    }else{
                        objectType = this.object;
                    }
                    div ='<a href="'+this.url+'" class="notification whithripple '+this.bg_read+'" note_id="'+this.ntf+'">\
                        <div class="notification-icon '+this.bg+'"><i class="material-icons">'+this.icon+'</i></div>\
                        <div class="notification-text">\
                        <div class="text-body">'+this.message+'</div>\
                        </div>\
                        </a>';                            
                    $('.notification-sidebar-body').append(div);
                }); 
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
     $animsition.animsition({onLoadEvent: false});
    notifications();
    markReadUnread();
    allReadUnread();
});