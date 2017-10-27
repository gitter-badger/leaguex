/*!
*   LEAGUEX
*   @copyright (C) 2014 fankstribe. All rights reserved.
*   @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*   License: Open source - MIT
*   @link http://www.fankstribe.org 
!*/

/* Add match result */

function addResult(){
    var homeScore = $('.home-score');
    var awayScore = $('.away-score');
    var scoreTeam1 = $('.home-score').attr('data-teamid');
    var scoreTeam2 = $('.away-score').attr('data-teamid');   
    var matchid = $('#matchid').val(); 
   
    $selectPlayers = $('.scorer .selectpicker.selectscorer, .event .selectpicker.selectevent');
    $selectPlayers.html('');
    $.ajax({
        url: base + "competitions/match/loadplayers",
        type: 'POST',
        dataType: 'JSON',
        data: 'match_id=' + matchid,
        success: function(response) {
            $selectPlayers.append('<option selected value="0">'+selectDefault+'</option>');
            $.each(response.playerslist, function(key, val) {
                var group = $('<optgroup>', {label:key});
                $.each(val, function(i,item){
                    $('<option/>', {value:item.id+','+item.player_team_id, text:item.player_name})
                        .appendTo(group).selectpicker('refresh');
                });
                
                $selectPlayers.append(group).selectpicker('refresh');
                
            });
           
        }
    });
    
    $selectEvents = $('.event .selectpicker.selecteventype');
    $selectEvents.html('');
    $.ajax({
        url: base + "competitions/match/loadevents",
        dataType: 'JSON',
        success: function(response){
            
            $.each(response.eventslist, function(key, val) {
                $selectEvents.append('<option value="'+ val.eventid +'">' + val.eventdesc + '</option>').selectpicker('refresh');
                    });
                }
            });
    
    //Submit Form
   if($('#addResultForm').length && $.fn.formValidation){
        var addresult = $('#addResultForm');
        $('#addResultForm').find('[name="playername[]"]').selectpicker().change(function(e){
            $('#addResultForm').formValidation('revalidateField', 'playername[]');
        }).end();
        addresult.formValidation({
            framework: "bootstrap",
            locale: cklocal,
            live: 'submitted',
            fields:{
                'time[]':{
                    enabled: false,
                    validators: {
                        notEmpty: {},
                        integer:{}
                    }
                },
                'playername[]':{
                    excluded: ':disabled',
                    enabled: false,
                    validators: {
                        callback:{                          
                            callback: function(value, validator, $field){
                                if(value.length === 1){
                                    return false;
                                }
                            return true;
                            }
                        }
                    }
                },
                'eventplayername[]':{
                    excluded: ':disabled',
                    enabled: false,
                    validators: {
                        callback:{                          
                            callback: function(value, validator, $field){
                                if(value.length === 1){
                                    return false;
                                }
                            return true;
                            }
                        }
                    }
                },
                'timevent[]':{
                    enabled: false,
                    validators:{
                        notEmpty: {},
                        integer:{}
                    }
                }
            }
        })
        //Add score 
        .on('change', '#selectPlayerName', function(){
            $(homeScore).effect('highlight', {color: "#e8f0fe"}, 1000);
            $(awayScore).effect('highlight', {color: "##e8f0fe"}, 1000);
            var check = $(this).val().length > 1;
                $('#addResultForm')
                .formValidation('enableFieldValidators', 'time[]', check)
                .formValidation('enableFieldValidators', 'playername[]', check);
            var datateam = $(this).closest('.scorer').find('input[data-team]');
            var teamid = $(this).closest('.scorer').find('input[data-team]').attr('data-team');
            var opteamid = $(this).find('option:selected').val().split(",").pop();
            var team = $(this).find('option:selected').val().split(",")[1];
            var score = $(this).closest('.scorer').find('input[data-team]').val(); 
            var owngoal = $(this).closest('.scorer').find('#owngoal'); 
            var scorevalsum = '';
            var scorevalsub = '';
            var teamval = $(this).closest('.playername').find('#teamidval');
            teamval.val(team);
            if((teamid !== opteamid)&&(teamid === scoreTeam1)||(teamid !== 0)){
                scorevalsum = +awayScore.val() + +score;
                scorevalsub = +homeScore.val() - +score; 
                awayScore.val(scorevalsum);
                homeScore.val(scorevalsub);
            }else{ 
                owngoal.selectpicker('val', 0);};
            if((teamid !== opteamid)&&(teamid === scoreTeam2)||(teamid !== 0)){
                scorevalsum = +homeScore.val() + +score;
                scorevalsub = +awayScore.val() - +score; 
                homeScore.val(scorevalsum);
                awayScore.val(scorevalsub);
            }else{
                owngoal.selectpicker('val', 0);};
            datateam.attr('data-team', opteamid);
            var sum1 = 0;
            var sum2 = 0;
            $('input[data-team="'+scoreTeam1+'"]').each(function(){
                sum1 += +$(this).val();
            });
            homeScore.val(sum1);
            $('input[data-team="'+scoreTeam2+'"]').each(function(){
                sum2 += +$(this).val();
            });
            awayScore.val(sum2);
            
        })
        .on('keyup', '[name="time[]"]', function(e){
            var playername = $('[name="playername[]"]');
            var isEmpty = $(this).val();
            if(isEmpty != '' && playername.length == 1){
                $('#addResultForm')
                .formValidation('enableFieldValidators', 'time[]', true)
                .formValidation('enableFieldValidators', 'playername[]', true);
            } else {
                $('#addResultForm')
                .formValidation('enableFieldValidators', 'time[]', false)
                .formValidation('enableFieldValidators', 'playername[]', false);
            }
        })
        //Convert score into own goal   
        .on('change', '#owngoal', function(){
            $(homeScore).effect('highlight', {color: "#e8f0fe"}, 1000);
            $(awayScore).effect('highlight', {color: "##e8f0fe"}, 1000);
            var select = $(this).closest('.scorer').find('#selectPlayerName'); 
            var scorevalsum = '';
            var scorevalsub = '';
            var score = $(this).closest('.scorer').find('input[data-team]').val(); 
            var datateam = $(this).closest('.scorer').find('input[data-team]');
            var teamid = $(this).closest('.scorer').find('input[data-team]').attr('data-team');
            if((teamid === scoreTeam1)&&(select.val() !== '0')){
                scorevalsum = +awayScore.val() + +score;
                scorevalsub = +homeScore.val() - +score; 
                awayScore.val(scorevalsum);
                homeScore.val(scorevalsub);
                datateam.attr('data-team', scoreTeam2);
            }else if((teamid === scoreTeam2)&&(select.val() !== '0')){
                scorevalsum = +homeScore.val() + +score;
                scorevalsub = +awayScore.val() - +score; 
                homeScore.val(scorevalsum);
                awayScore.val(scorevalsub);
                datateam.attr('data-team', scoreTeam1);
            };
        })
        //Add event 
        .on('change', '#selectEventPlayerName', function(){
            var check = $(this).val().length > 1;
            $('#addResultForm')
            .formValidation('enableFieldValidators', 'timevent[]', check)
            .formValidation('enableFieldValidators', 'eventplayername[]', check);
            
            var team = $(this).find('option:selected').val().split(",")[1];
            var teamval = $(this).closest('.eventplayername').find('#evteamidval');
            teamval.val(team);
        })
        .on('keyup', '[name="timevent[]"]', function(e){
            var eventplayername = $('[name="eventplayername[]"]');
            var isEmpty = $(this).val();
            if(isEmpty != '' && eventplayername.length == 1){
                $('#addResultForm')
                .formValidation('enableFieldValidators', 'timevent[]', true)
                .formValidation('enableFieldValidators', 'eventplayername[]', true);
            } else {
                $('#addResultForm')
                .formValidation('enableFieldValidators', 'time[]', false)
                .formValidation('enableFieldValidators', 'playername[]', false);
            }
        })
        .on('added.field.fv', function(e, data){
            if(data.field === 'playername[]' || data.field === 'owngoal[]' || data.field === 'eventplayername[]' || data.field === 'eventype[]'){
                data.element.selectpicker({
                    style: 'select-with-transition',
                    iconBase: 'fa',
                    tickIcon: 'fa-check',
                    dropupAuto: false
                })
                .on('change', function(e){
                     $('#addResultForm').formValidation('revalidateField', data.element);
                });
            }
        })
        .on('click', '.add-scorer .add-link a', function(){
            var $template = $('#addresultTemplate'),
            $clone = $template
                .clone()
                .removeClass('hide')
                .removeAttr('id')
                .insertBefore($template);
            var remove = $(this).closest('.modresult-scorer').find('.player-remove');
            var removeclone = $clone.find('.player-remove');
            $clone.find('.bootstrap-select').remove();
            $clone.find('#goalscore').attr('name','goalscore[]');
            $clone.find('#selectPlayerName').attr('name','playername[]');
            $clone.find('#owngoal').attr('name','owngoal[]');
            $clone.find('#time').attr('name','time[]');
            $clone.find('#teamidval').attr('name','teamidval[]');
            remove.show();
            removeclone.show();
            $('#addResultForm')
                .formValidation('addField', $clone.find('[name="playername[]"]'))
                .formValidation('addField', $clone.find('[name="owngoal[]"]'))
                .formValidation('addField', $clone.find('[name="time[]"]'));
        })
        .on('click', '.add-event .add-link a', function(){
            var $template = $('#addeventTemplate'),
            $clone = $template
                .clone()
                .removeClass('hide')
                .removeAttr('id')
                .insertBefore($template);
            var remove = $(this).closest('.modresult-event').find('.event-player-remove');
            var removeclone = $clone.find('.event-player-remove');
            $clone.find('.bootstrap-select').remove();
            $clone.find('#eventscore').attr('name','eventscore[]');
            $clone.find('#selectEventPlayerName').attr('name','eventplayername[]');
            $clone.find('#selectEvenType').attr('name','eventype[]');
            $clone.find('#timevent').attr('name','timevent[]');
            $clone.find('#evteamidval').attr('name','evteamidval[]');
            remove.show();
            removeclone.show();
            $('#addResultForm')
                .formValidation('addField', $clone.find('[name="eventplayername[]"]'))
                .formValidation('addField', $clone.find('[name="eventype[]"]'))
                .formValidation('addField', $clone.find('[name="timevent[]"]'));
        })        
        .on('click', '.player-remove', function(){
            $(homeScore).effect('highlight', {color: "#e8f0fe"}, 1000);
            $(awayScore).effect('highlight', {color: "##e8f0fe"}, 1000);
            var $row = $(this).closest('.scorer');
            var target = $(this).closest('.scorer').find('input[data-team]');
            var icondelete = $('.player-remove');
            var sum1 = 0;
            var sum2 = 0;
            $('input[data-team="'+scoreTeam1+'"]').not(target).each(function(){
                sum1 += Number($(this).val());
            });
            homeScore.val(sum1);
            $('input[data-team="'+scoreTeam2+'"]').not(target).each(function(){
                sum2 += Number($(this).val());
            });
            awayScore.val(sum2);
            $('#addResultForm')
                .formValidation('removeField', $row.find('[name="playername[]"]'))
                .formValidation('removeField', $row.find('[name="time[]"]'));
            if((icondelete).length === 3){
                $row.remove();
                icondelete.hide();
            }else{
                $row.remove();
            }  
        })
        .on('click', '.event-player-remove', function(){
            var $row = $(this).closest('.event');
            var icondelete = $('.event-player-remove');
            $('#addResultForm')
                .formValidation('removeField', $row.find('[name="eventplayername[]"]'))
                .formValidation('removeField', $row.find('[name="timevent[]"]'));
            if((icondelete).length === 3){
                $row.remove();
                icondelete.hide();
            }else{
                $row.remove();
            }  
        })
        .on('err.field.fv', function(e, data) {
            data.element
                .data('fv.messages')
                .find('.help-block[data-fv-for="' + data.field + '"]').hide();
        })
        .on('success.form.fv', function(e){
            $('.modal-content').waitMe({
                effect: '',
                bg: 'rgba(255,255,255,0.7)',
                color: '#f44336'
            });
            e.preventDefault();
            var $form = $(e.target),
            fv = $form.data('formValidation');
            setTimeout(function() {
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    dataType: "json",
                    success:function(response){
                        $('.modal-content').waitMe("hide");
                        if(response.success){
                                                  
                            $('.match-box-teams').find('.home-score').html(response.showscore.homescore);
                            $('.match-box-teams').find('.away-score').html(response.showscore.awayscore);
                                                       
                            $.each(response.showscorers, function(i, val){
                                $('.match-box-events').find('.match-scorers').append(
                                    '<a href="#" class="event animated slideInDown">'+
                                        '<div class="scorer '+(val.teamid === scoreTeam1 ? 'right' : 'left')+'">'
                                            +(val.teamid === scoreTeam1 ?
                                            '<span>'+ val.timescore +'</span>'+
                                            '<img class="event-icon" src="'+ base +'assets/img/icons/soccerball.png">'+
                                            '<img class="player-image" src="'+ val.urlimage + val.playerimage +'.png" onerror="imgError(this);">'+
                                            val.playername
                                            :
                                            '<img class="player-image" src="'+ val.urlimage + val.playerimage +'.png" onerror="imgError(this);">'+
                                            val.playername+
                                            '<img class="event-icon" src="'+ base +'assets/img/icons/soccerball.png">'+
                                            '<span>'+ val.timescore +'</span>')+
                                        '</div>'+   
                                    '</a>'
                                );
                            });
                            
                             $.each(response.showevents, function(i, val){
                                $('.match-box-events').find('.match-events').append(
                                    '<a href="#" class="event animated slideInDown">'+
                                        '<div class="eventype '+(val.teamid === scoreTeam1 ? 'right' : 'left')+'">'
                                            +(val.teamid === scoreTeam1 ?
                                            '<span>'+ val.timevent +'</span>'+
                                            '<img class="event-icon" src="'+ base +'assets/img/icons/'+val.evicon+'">'+
                                            '<img class="player-image" src="'+ val.urlimage + val.playerimage +'.png" onerror="imgError(this);">'+
                                            val.playername
                                            :
                                            '<img class="player-image" src="'+ val.urlimage + val.playerimage +'.png" onerror="imgError(this);">'+
                                            val.playername+
                                            '<img class="event-icon" src="'+ base +'assets/img/icons/'+val.evicon+'">'+
                                            '<span>'+ val.timevent +'</span>')+
                                        '</div>'+   
                                    '</a>'
                                );
                            }); 
                                             
                            $('.score-container .advice-text, .score-container .unplayed').remove();
                            $('.match-box-teams .score, .match-box-teams .match-info').removeClass('hide');
                            $('.float-button').hide();
                        }
                        $form.parents('.bootbox').modal('hide');
                        $.notify({message: updateSuccessMessage});
                    }
                });
            }, 600); 
        });
    }
    
    $('#addResult').on('click', function(){  
        bootbox.dialog({
            message: $('#addResultForm'),
            closeButton: false,
            show: false,
            className:'bootbox-matchplay',
            animate: true,
            buttons: {
                submit: {
                    label: formButtonSave,
                    className: "btn-info",
                    callback: function(e) {
                        addresult.submit();
                        return false;
                    }
                },
                cancel: {
                    label: formButtonClose,
                    className: "btn-info",
                    callback: function(){
                        
                    }
                }
            }
        }).on('shown.bs.modal', function() {
            $('#addResultForm').show();
            if($(window).width() < 750) {
                $('.modal .modal-body-custom').css('overflow-y', 'hidden'); 
                $('.modal .modal-body-custom').css('max-height', $(window).height() - 124);
                $('.modal .modal-body-custom').css('height', $(window).height() - 124);
            }
            $(window).on('resize', function() {
            if($(window).width() < 750) {
                $('.modal .modal-body-custom').css('overflow-y', 'hidden'); 
                $('.modal .modal-body-custom').css('max-height', $(window).height() - 124);
                $('.modal .modal-body-custom').css('height', $(window).height() - 124);
            }
            });
            
        }).on('hide.bs.modal', function(e) {
            $('#addResultForm').hide().appendTo('body');
        }).modal('show');
    }); 
}

/* Comments system */

function matchComments(){ 
    
    autosize($('textarea'));
    lightbox.option({'showImageNumberLabel': false});
                
    // Set size of image container (onload)
    $(window).on('load resize', function(){
        $('div.resp-image-comment').each(function(){
            $(this).css({'padding-top': $(this).children('img').height()});      
        });
    });
}

function submitComment(){
    // Submit comment
    $('#submitComment').attr('disabled', true);
    $('#textcontent').bind('teaxtarea keyup', function(){
        var textarea = $("textarea");
        if($.trim(textarea.val()).length > 0) {
            $('#submitComment').prop('disabled' , false);
        }else{
            $('#submitComment').prop('disabled' , true);
        }
    });
    $('#submitComment').on('click', function(){
        var matchid = $('#matchid').val(); 
        var userid = $('#userid').val();
        var imageid = $('#imageid').val();
        var content = $('#textcontent').val();
        var data = 'match_id='+matchid+ '&user_id='+userid+ '&comments_images='+imageid+ '&comment_content='+content;
        $('.comments-widget').waitMe({
            effect: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#f44336'
        });
        setTimeout(function(){
        $.ajax({
           type: 'POST',
           url: base + "competitions/match/insertComments",
           data: data,
           cache: false,
           success: function(response){
                if(response.success){
                    comment = response.showcomment;
                    var li =  $('<li class="comment">'+
                                    '<a class="comment-avatar pull-left"><img src="'+base+'assets/img/avatars/'+comment.useravatar+'"></a>'+
                                    '<div class="comment-text-container">'+
                                        '<div class="comment-user">'+
                                            '<a class="comment-user-name">'+comment.username+'</a>'+
                                        '</div>'+
                                        '<div class="comment-text">'+comment.content+'</div>'+
                                        '<a class="imageBox '+comment.hidebox+'" href="'+base+'assets/img/users_images/'+comment.userimage+'" data-lightbox="'+comment.userimage+'">'+
                                            '<div class="resp-image-comment-wrap">'+
                                                '<div class="resp-image-comment-container" style="max-width: 260px;">'+
                                                    '<div class="resp-image-comment">'+
                                                        '<img src="'+base+'assets/img/users_images/'+comment.userimage+'" alt="userimage">'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</a>'+
                                        '<div class="comment-time">'+comment.time+'</div>'+
                                    '</div>'+
                                    '<div class="comment-actions-container">'+
                                        '<ul class="comment-actions">'+
                                            '<li class="dropdown comment-menu">'+
                                                '<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><i class="material-icons md-18">more_vert</i></a>'+
                                                '<ul class="dropdown-menu dropdown-menu-right" role="menu" data-dropdown-in="zoomIn" data-dropdown-out="zoomOut">'+
                                                    '<li><a class="delete ripple-effect" data-id="'+comment.commentid+'" href="#">Elimina</a></li>'+
                                                    '<li><a class="ripple-effect" href="#">Modifica</a></li>'+
                                                '</ul>'+
                                            '</li>'+
                                        '</ul>'+
                                    '</div>'+
                                '</li>').hide();
                    $('.comments-widget').waitMe("hide"); 
                    $('#submitComment').attr('disabled', true);
                    $('textarea').val('');
                    $('#imageid').val('');
                    $('#thumbImg').attr('src', '');
                    $('#thumbImg').hide();
                    $(li).hide().prependTo('.comments-list').slideDown();
                    $('div.resp-image-comment:first').css({'padding-top': $('div.resp-image-comment:first').children('img').height()}); 
                    $(li).show();
                    $.notify({message: commentAddSuccess});
                    $('.float-button').fadeIn('medium');
                }
            }
        });
        }, 600); 
       return false;
    });
} 

function removeComment(){    
     // Remove comment
    $('.comments-list').on('click','.delete', function(e){
        e.preventDefault();
        var comment_id = $(this).attr("data-id");
        var comment_Cnt = $(this).closest('li.comment');
        var box_menu = $(this).closest('ul.dropdown-menu');
        bootbox.dialog({
            message: alertMessageDeleteComment,
            title: alertHeader,
            size: 'small',
            buttons: {
                danger: {
                    label: alertConfirm,
                    className: "btn-default",
                    callback: function() {
                    success();
                    }
                },
                main: {
                    label: alertCancel,
                    className: "btn-info",
                    callback: function() {}
                }
        }
        });
        function success() {
            $.ajax({
                type: "POST",
                url: base + "competitions/match/deleteComment",
                data: 'comment_id=' + comment_id,
                cache: false,
                success: function(result){
                    if(result === ''){
                    comment_Cnt.slideUp('slow', function(){$(this).hide();});
                    box_menu.hide(); 
                    }
                }
            });
        }
    return false;
    }); 
}

/* Init functions */
$(document).ready(function(){
addResult();    
matchComments();
submitComment();
removeComment();
});