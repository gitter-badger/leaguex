/*!
*   LEAGUEX
*   @copyright (C) 2014 fankstribe. All rights reserved.
*   @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*   License: Open source - MIT
*   @link http://www.fankstribe.org 
!*/

/* Funtion to trigger the refresh event */

bootNotify();

/* Function to display notifications */

//widget side

$(document).on('click', '.dropdown-notify', function(){
    $('html').toggleClass('notification-sidebar-opened');
    $('.totalntf').text(''); 
    $('.notification-container').find('media-list').html('');  
    user = $(this).find('input[name="user_id"]').val();
    load_ntf(user);
   
    $('.dropdown-menu .viewport').niceScroll({cursorwidth: '4px',
        cursorborder: '0px',
        cursorcolor: '#ccc',
        railalign: 'right',
    });    
});

//page side

$(document).on('click', '#note-tab', function(){
    $('.totalntf').text(''); 
    $('.notify-tab .media-list').empty();  
    user = $(this).find('input[name="user_id"]').val();      
    load_ntf_page(user);    
});
$(document).ready(function(){
    if($('.tab-container.active #note-tab').length){
        $('.totalntf').text(''); 
        $('.notify-tab .media-list').empty();  
        user = $(this).find('input[name="user_id"]').val();      
        load_ntf_page(user);
    }
});

/* Function to mark as read, unread */

$(document).on('click','.media-list a', function (){    
    note_id = $(this).attr("note_id");
    $.ajax({
        type: "POST",
        url: base + "notification/notification/mark_read",
        data: {id: note_id}});        
    });

$(document).on('click','.media-list a .visibility_off', function (e){
    e.preventDefault();
    note_id = $(this).attr("note_id");
    $(this).toggleClass('visibility_off done');
    $(this).closest('.media').addClass('read');
    $(this).closest('.media').removeClass('unread');
    $.ajax({
        type: "POST",
        url: base + "notification/notification/mark_read",
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
                    else
                    {$(".ntfcount").printf(allunread,totalntf);
                }
            }  
        }
    });
    return false;
});    

$(document).on('click','.media-list a .done', function (e){
    e.preventDefault();
    note_id = $(this).attr("note_id");
    $(this).toggleClass('done visibility_off');
    $(this).closest('.media').addClass('unread');
    $(this).closest('.media').removeClass('read');
    $.ajax({
        type: "POST",
        url: base + "notification/notification/mark_unread",
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
                    else
                    {$(".ntfcount").printf(allunread,totalntf);
                }
            }  
        }
    });
    return false;
}); 

//Mark all read, all unread in page side
$(document).on('click','.notification-header .markall', function (e){
    e.preventDefault();   
    user = $('input[name="user_id"]').val();
    var el_unread = $('.media-list a .visibility_off');
    var el_read = $('.media-list a .done');
    var check_note = '';
    $.ajax({
        type: "POST",
        async: false,
        url: base + "notification/notification/count_unread",
        data: {id: user},
        success: function(data){
            if(data.success){
                check_note = data.totalntf;                
            }  
        }
    }); 
    if(check_note > 0){
        $(el_unread).toggleClass('visibility_off done');
        $.ajax({
            type: "POST",
            url: base + "notification/notification/mark_all_read",
            data: {id: user},
            success: function(data){
                if(data.success){
                    totalntf = data.totalntf;
                    $('.ntfcount').empty();
                    if(totalntf == 1){
                        $(".ntfcount").printf(unread,totalntf);}
                        else if(totalntf == 0){
                        $(".ntfcount").printf(allread,totalntf);}                        
                    else
                    {$(".ntfcount").printf(allunread,totalntf);
                    }
                }  
            }
        }); 
    }else{
        $(el_read).toggleClass('done visibility_off');
        $.ajax({
            type: "POST",
            url: base + "notification/notification/mark_all_unread",
            data: {id: user},
            success: function(data){
                if(data.success){
                    totalntf = data.totalntf;
                    $('.ntfcount').empty();
                        if(totalntf == 1){
                        $(".ntfcount").printf(unread,totalntf);}
                        else if(totalntf == 0){
                        $(".ntfcount").printf(allread,totalntf);}                        
                        else
                        {$(".ntfcount").printf(allunread,totalntf);
                    }
                }  
            }
        });   
    }
}); 

/* Function to update notifications */
function bootNotify()
{
    refresh = setInterval(function(){ 
        $.ajax({
            type: 'GET',
            url : base + "notification/notification/updates/",
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

/* Function to load notifications */

//widget side

var limit = 1; 
function load_ntf(user,limit){
    $("#loadnote").show();
    $.ajax({
        type: "POST", 
        url: base + "notification/notification/notifications",
        data: {user:user, limit:limit},
        cache: false,
        success: function(response){
            if(response.success){
                morenote = response.morenote;
                $('.notification-container .media-list').html('');
                if(morenote.more){
                    $('.dropdown-menu .viewport').scroll(function(){
                        if($('.dropdown-menu .viewport').scrollTop() + $('.dropdown-menu .viewport').height() >= $('.media-list').height()-20){
                             $("#loadnote").show();
                            setTimeout(function() {
                            load_ntf(morenote.id , morenote.limit);
                            $("#loadnote").hide();
                            }, 1600);
                        }
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
                    var message = $.sprintf(this.message,objectType);                    
                    div ='<a href="'+this.url+'" class="media '+this.bg_read+' notification fadeIn" note_id="'+this.ntf+'">\
                        <span class="media-object '+this.bg+'"><i class="material-icons">'+this.icon+'</i></span>\
                        <span class="media-body">\
                        <span class="media-text">'+message+'</span>\
                        </span>\
                        <span class="media-meta"><i class="material-icons md-18 '+this.is_read+'" note_id="'+this.ntf+'"></i></span>\
                        </a>';                            
                    $('.notification-container .media-list').append(div);
                                                       
                }); 
                 $("#loadnote").hide();
            }
        }
    });
}

//page side
var limit = 1; 
function load_ntf_page(user,limit){
    setTimeout(function() {
    $('.hide-block').hide();
    $("#loading").show();
    $.ajax({
        type: "POST", 
        url: base + "notification/notification/notifications",
        data: {user:user, limit:limit},
        cache: false,
        success: function(response){
            if(response.success){
                morenote = response.morenote;
                $('.notify-tab .media-list').html('');
                if(morenote.more){
                    $(window).bind('scroll', function(){                       
                        if($(window).scrollTop() + $(window).height() == $(document).height()){                             
                            $("#loaderBottom").show();
                            setTimeout(function() {
                                load_ntf_page(morenote.id , morenote.limit);
                                
                            $("#loaderBottom").hide();
                            }, 600);
                        }
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
                    var message = $.sprintf(this.message,objectType);                              
                    div ='<a href="'+this.url+'" class="media notification" note_id="'+this.ntf+'">\
                        <div class="media-object '+this.bg+'"><i class="material-icons">'+this.icon+'</i></div>\
                        <div class="media-body">\
                        <span class="media-text">'+message+'</span>\
                        </div>\
                        <div class="media-meta"><span class="btn btn-fab btn-fab-mini no-shadow no-color-bg"><i class="material-icons '+this.is_read+'" note_id="'+this.ntf+'"></i></span></div>\
                        </a>';                            
                    $('.notify-tab .media-list').append(div);                           
                });
                $("#loading").hide();
                $('.hide-block').show();
            }
        }
    });
    }, 800);
}
