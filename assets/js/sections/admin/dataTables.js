/*!
*   LEAGUEX
*   @copyright (C) 2017 fankstribe. All rights reserved.
*   @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*   License: Open source - MIT
*   @link http://www.fankstribe.org 
!*/

/* Set tables default values */
$.extend(true, $.fn.dataTable.defaults, {
    pageLength: 25,
    processing: true,
    pagingType: "simple",
    dom: "<'datatable-top'f>rt<'datatable-bottom'lip>",
    language: {
        url: tableHeader,
        search: "_INPUT_",
        lengthMenu: "<select class='selectpicker show-tick'>"+
                    "<option value='25'>25</option>"+
                    "<option value='50'>50</option>"+
                    "<option value='75'>75</option>"+
                    "<option value='100'>100</option>"+
                    "</select>",
        searchPlaceholder: searchPlaceholder,
        info: "_START_ - _END_ of _TOTAL_",
        infoFiltered: "",
        paginate: {
            previous: "<i class='material-icons'>keyboard_arrow_left</i>",
            next: "<i class='material-icons'>keyboard_arrow_right</i>"
        }
    }
});
/* Set animation */
$.fn.extend({
animateCss: function (animationName, callback) {
    var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
    this.addClass('animated ' + animationName).one(animationEnd, function() {
        var obj = $(this);
        obj.removeClass('animated ' + animationName);
        if(callback && typeof callback === 'function') callback(obj);
    });
  }
});

function compareText(val1, val2){
    var firstchar = val1.substr(0,1);
    var text1 = val1.substr(0,3);
    var text2 = val2.substr(0,3);
    var val3 = val1.substr(-3, 2);
        if(text1 === text2){
            var compare = firstchar+val3;
        }else{
            var compare = text1;
        }
    return compare;
}

/* Show leagues list */
function leaguesListTable() {
    if($('#leaguesList').length && $.fn.DataTable) {
        var getdetails = $('#main-wrapper').find('input[name="getdetails"]').val();
        if(getdetails == '0') {
            var tabledetails = 'column';
            var detailsvisible = $.fn.dataTable.Responsive.display.childRowImmediate;
        } else {
            var tabledetails = 'inline';
            var detailsvisible = $.fn.dataTable.Responsive.display.childRow;
        }
        $.fn.dataTable.moment('DD/MM/YYYY');
        $('#leaguesList').DataTable({
            serverMethod: "GET",
            ajaxSource: base + "admin/competitions/leagues_list/showleagues",
            responsive: {
                details: {display: detailsvisible, type: tabledetails}
            },
            order: [0, "desc"],
            aoColumns: [
                {data: "competition_id", bVisible: false},
                {data: "leagueinfo", className: 'all'},
                {data: "counteams"},
                {data: "competition_registration_date",
                    render: function(data, type, row) {
                        return(moment(data).format("DD/MM/YYYY"));
                    }
                },
                {bSortable: false, data: "action" }
            ]
        });
    }
}

/* Add league */
function addLeague() {
    var leaguestable = $('#leaguesList').DataTable();
    if($('#addLeagueForm').length && $.fn.formValidation) {
        $('#addLeagueForm').find('[name="leagueteams[]"]').selectpicker().change(function(e) {
            $('#addLeagueForm').formValidation('revalidateField', 'leagueteams[]');
        }).end();
        $('#addLeagueForm').formValidation({
            framework: "bootstrap",
            excluded: ':disabled',
            button: {
                selector: '#btnAddLeagueForm',
                disabled: 'disabled'
            },
            locale: cklocal,
            live: 'submitted',
            fields: {
                leaguename: {
                    validators: {
                        notEmpty: {}
                    }
                },
                'leagueteams[]': {
                    validators: {
                        callback: {
                            message: validateMessageMultipleTeams,
                            callback: function(value, validator, $field) {
                                var options = validator.getFieldElements('leagueteams[]').val();
                                return(options != null && options.length > 1);
                            }
                        }
                    }
                }
            }
        })
        .on('err.validator.fv', function(e, data) {
            if((data.field === 'leaguename') || (data.field === 'leagueteams')) {
                data.element
                .data('fv.messages')
                .find('.help-block[data-fv-for="' + data.field + '"]').hide()
                .filter('[data-fv-validator="' + data.validator + '"]').show();
            }
        })
        .on('success.form.fv', function(e) {
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
                    success: function(response) {
                        if(response.success) {
                            $('.modal-content').waitMe("hide");
                            fv.disableSubmitButtons(false);
                            newleague = response.addleague;
                            var nodeLeaguetable = leaguestable.row.add({
                                "competition_id": newleague.leagueid,
                                "leagueinfo": '<img src="../../assets/img/competitions_logo/' + newleague.leaguelogo + '">\
                                               <span class="img-cell">' + newleague.leaguename + '</span>',
                                "counteams": newleague.counteams,
                                "competition_registration_date": newleague.regdate,
                                "action": '<a href="#" id="' + newleague.leagueid + '" class="table-icon btn btn-fab btn-fab-custom make-fx no-shadow no-color-bg fixture">\
                                           <i class="material-icons event_avalaible"></i>\
                                           <i class="fa fa-refresh fa-spin" style="display: none"></i>\
                                           </a>\
                                           <a href="#" id="' + newleague.leagueid + '" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg delete">\
                                           <i class="material-icons">delete</i>\
                                           </a>\
                                           <span class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">\
                                           <i class="material-icons text-red">fiber_manual_record</i>\
                                           </span>'
                            }).draw().node();
                            $(nodeLeaguetable).addClass('animated fadeIn');
                            $(nodeLeaguetable).effect('highlight', {color: "#e8f0fe"}, 600);
                            $.notify({message: leagueAddSuccess});
                        }
                        $form.parents('.bootbox').modal('hide');
                    }
                });
            }, 600); 
        });
    }

    $('#addLeague').on('click', function() {
        bootbox.dialog({
            message: $('#addLeagueForm'),
            show: false,
            className:'bootbox-form',
            closeButton: false,
        }).on('shown.bs.modal', function() {
            $('#addLeagueForm').show()
                .formValidation('resetForm', true);
        }).on('hide.bs.modal', function(e) {
            $('#addLeagueForm').hide().appendTo('body');
        }).modal('show');

        $selectTeams = $('#selectTeams');
        $selectTeams.html('');
        $.ajax({
            url: base + "admin/competitions/leagues_list/loadteams",
            dataType: 'JSON',
            success: function(response) {
                $.each(response.teamslist, function(key, val) {
                    $selectTeams.append('<option value="' + val.teamid + '">' + val.teamname + '</option>').selectpicker('refresh');
                });
            }
        });
    });
}

/* Make fixture league */
function makeFixture() {
    $('#leaguesList').on('click', '.make-fx.fixture', function(e) {
        e.preventDefault();
        var leaguestable = $('#leaguesList').DataTable();
        var id = $(this).attr('id');
        var icon = $(this).find('.event_avalaible');
        var spinner = $(this).find('.fa-refresh');
        bootbox.dialog({
            message: alertMessageMakeFixture,
            title: alertHeader,
            size: "small",
            buttons: {
                danger: {
                    label: alertConfirm,
                    className: "btn-default",
                    callback: function() {
                        icon.hide();
                        spinner.show();
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

        function success(){
            $.ajax({
                url: 'leagues_list/makefixture',
                type: 'POST',
                data: 'id=' + id,
                success: function(result) {
                    if(result == '') {
                        spinner.hide();
                        leaguestable.ajax.reload();
                        $.notify({message: leagueMakeFixtureSuccess});
                    }
                }
            });
        }
    });
}

/* Delete league */
function leagueDelete() {
    $('#leaguesList tbody').on('click', '.delete', function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var childshow = $(this).parents(".child");
        if((childshow).length) {
            var parent = $(this).parents("tr").prev();
        } else {
            var parent = $(this).parents("tr");
        }
        var leaguestable = $('#leaguesList').DataTable();
        bootbox.dialog({
            message: alertMessageDeleteLeague,
            title: alertHeader,
            size: "small",
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
                url: 'leagues_list/deleteleague',
                type: 'POST',
                data: 'id=' + id,
                success: function(result) {
                    if(result == '') {
                        $(parent).effect('highlight', {color: "#e8f0fe"}, 1000, function() {
                            $(parent).fadeOut('slow', function() {
                                leaguestable.row(parent).remove().draw(false);
                            });
                        });
                        $.notify({message: leagueDeleteSuccess});
                    }
                }
            });
        }
    });
}

/* Show fixtures league list */
function fixtureListTable() {
    if($('#editLeague').length && $.fn.DataTable) {
        var getleagueid = $('#main-wrapper').find('input[name="getleagueid"]').val();
        var tabledetails = 'column';
        var detailsvisible = $.fn.dataTable.Responsive.display.childRowImmediate;
        var table = $('#editLeague').DataTable({
            serverMethod: "POST",
            ajax:{
                url: base + "admin/competitions/edit_league/showfixture",
                data: function(d){
                    d.id = getleagueid;
                }
            }, 
            responsive: {
                details: {
                    display: detailsvisible,
                    type: tabledetails
                }
            },
            rowId: 'match_id',
            order: [0, "asc"],
            aoColumns: [
                {data: "match_matchday", bVisible: false},
                {data: "match_id", bVisible: false},
                {data: "team1", bSortable: false, className: "not-mobile"},
                {data: "score", bSortable: false, className: "dt-center"},
                {data: "team2", bSortable: false, className: "not-mobile, dt-right"}],
            drawCallback: function(settings) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last= null;
                api.column(0, {page:'current'} ).data().each( function (match_matchday, i) {
                    if (last !== match_matchday) {
                        $(rows).eq(i).before(
                        '<tr class="group"><td colspan="5">'+leagueMatchdayTitle+'&nbsp;'+match_matchday+'</td></tr>'
                        );
                        last = match_matchday;
                    }
                });
            }
        });
        // Order by the grouping
        $('#editLeague tbody').on( 'click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
                table.order( [ 0, 'desc' ] ).draw();
            }else {
                table.order( [ 0, 'asc' ] ).draw();
            }
        });
    }
}
/* Edit match */
function editMatch(matchid){
    var homeScore = $('.home-score');
    var awayScore = $('.away-score');
    $selectPlayers = $('.scorer .selectpicker.selectscorer, .event .selectpicker.selectevent');
    $selectPlayers.html('');
    $.ajax({
        url: base + "admin/competitions/edit_league/loadplayers",
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
        url: base + "admin/competitions/edit_league/loadevents",
        dataType: 'JSON',
        success: function(response){
            $.each(response.eventslist, function(key, val) {
                $selectEvents.append('<option value="'+ val.eventid +'">' + val.eventdesc + '</option>').selectpicker('refresh');
            });
        }
    });
    $selectWalkover = $('.walkover .selectpicker.selectwalkover');
    $selectWalkover.html('');
    $.ajax({
        url: base + "admin/competitions/edit_league/loadteams",
        type: 'POST',
        dataType: 'JSON',
        data: 'match_id=' + matchid,
        success: function(teamslist){
             $.each(teamslist, function(key, val) {
            $selectWalkover.append('<option value="'+ val.value +'">' + val.text + '</option>').selectpicker('refresh');
            });
        }
    });
    if($('#editMatchForm').length && $.fn.formValidation){
        var fixturetable = $('#editLeague').DataTable();
        var editmatch = $('#editMatchForm');
        $('#editMatchForm').find('[name="playername[]"]').selectpicker().change(function(e){
            $('#editMatchForm').formValidation('revalidateField', 'playername[]');
        }).end();
        $(editmatch).formValidation({
            framework: "bootstrap",
            locale: cklocal,
            live: 'submitted',
            fields:{
                'time[]':{
                    validators: {
                        notEmpty: {},
                        integer:{}
                    }
                },
                'playername[]':{
                    excluded: ':disabled',
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
                    validators:{
                        notEmpty: {},
                        integer:{}
                    }
                },
                'walkoverteamname':{
                    excluded: ':disabled',
                    validators: {
                        callback:{                          
                            callback: function(value, validator, $field){
                                if(value === ''){
                                    return false;
                                }
                            return true;
                            }
                        }
                    }
                },
            }
        })
        .on('change', '#selectPlayerName', function(e){
            var scoreTeam1 = $('.home-score').attr('data-teamid');
            var scoreTeam2 = $('.away-score').attr('data-teamid');
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
        .off('change', '#owngoal')
        .on('change', '#owngoal', function(){
            var select = $(this).closest('.scorer').find('#selectPlayerName');
            var scoreTeam1 = $('.home-score').attr('data-teamid');
            var scoreTeam2 = $('.away-score').attr('data-teamid');   
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
        .on('change', '#selectEventPlayerName', function(){
            var team = $(this).find('option:selected').val().split(",")[1];
            var teamval = $(this).closest('.eventplayername').find('#evteamidval');
            teamval.val(team);
        })
        .on('change', '#selectWalkoverTeam', function(){
            $('#morewalkover').attr('disabled', true);
            var team = $(this).find('option:selected').val();
            var scoreTeam1 = $('.home-score').attr('data-teamid');
            if(team === scoreTeam1){
                awayScore.val('0');
                homeScore.val('3');
            }else{
                homeScore.val('0');
                awayScore.val('3');
            };
        })
        .off('click', '.add-scorer .add-link')
        .on('click', '.add-scorer .add-link', function(){
            var loadpic = $(this).find('.fa-spin');
            var button = $(this).find('.material-icons');
            button.hide();
            loadpic.show();
            setTimeout(function() {
                var $template = $('#addresultTemplate');
                $clone = $template
                    .clone()
                    .removeClass('hide')
                    .removeAttr('id')
                    .insertAfter($template);
                $clone.animateCss('slideInLeft', function (obj){obj;});
                $('.modal .modal-body-custom').getNiceScroll().resize();
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
                $('#editMatchForm')
                    .formValidation('addField', $clone.find('[name="playername[]"]'))
                    .formValidation('addField', $clone.find('[name="owngoal[]"]'))
                    .formValidation('addField', $clone.find('[name="time[]"]'));
                $('.no-scorers-wrap').hide();
                loadpic.hide();
                button.show();
            }, 400);        
        })
        .off('click', '.add-event .add-link')
        .on('click', '.add-event .add-link', function(){
            var loadpic = $(this).find('.fa-spin');
            var button = $(this).find('.material-icons');
            button.hide();
            loadpic.show();
            setTimeout(function() {
                var $template = $('#addeventTemplate'),
                $clone = $template
                    .clone()
                    .removeClass('hide')
                    .removeAttr('id')
                    .insertAfter($template);
                $clone.animateCss('slideInLeft', function (obj){obj;});
                $('.modal .modal-body-custom').getNiceScroll().resize();
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
                $('#editMatchForm')
                    .formValidation('addField', $clone.find('[name="eventplayername[]"]'))
                    .formValidation('addField', $clone.find('[name="eventype[]"]'))
                    .formValidation('addField', $clone.find('[name="timevent[]"]'));
                $('.no-events-wrap').hide();
                loadpic.hide();
                button.show();
            }, 400);            
        })
        .off('click', '.add-walkover .add-link')
        .on('click', '.add-walkover .add-link', function(){
            $(this).attr('disabled', true);
            $('.no-walkover-wrap').show()
            $('.no-walkover img').hide();
            $('.no-walkover .loadpic').show();
            setTimeout(function() {
            var $template = $('#addwalkoverTemplate'),
                $clone = $template
                    .clone()
                    .removeClass('hide')
                    .removeAttr('id')
                    .insertBefore($template).hide().slideDown(200);
                $('.modal .modal-body-custom').getNiceScroll().resize();    
                var remove = $(this).closest('.modresult-walkover').find('.walkover-team-remove');
                var removeclone = $clone.find('.walkover-team-remove');    
                $clone.find('.bootstrap-select').remove();
                $clone.find('#selectWalkoverTeam').attr('name','walkoverteamname');
                remove.show();
                removeclone.show();
                $('#editMatchForm')
                    .formValidation('addField', $clone.find('[name="walkoverteamname"]'))
                $('.no-walkover .loadpic').hide();
                $('.no-walkover-wrap').hide();
                $(".modresult-addevent").slideUp(200);
                $(".modresult-addscore").slideUp(200);
            }, 400);    
        })
        .on('added.field.fv', function(e, data){
            if(data.field === 'playername[]' || data.field === 'timevent[]' || data.field === 'time[]' || data.field === 'eventplayername[]' || data.field === 'eventype[]' || data.field === 'owngoal[]' || data.field === 'walkoverteamname'){
                data.element.selectpicker({
                    style: 'select-with-transition',
                    iconBase: 'material-icons',
                    tickIcon: 'done',
                    dropupAuto: true,
                    container: 'body',
                    size: '6'
                })
                .on('change', function(e){
                     $('#editMatchForm').formValidation('revalidateField', data.element);
                });
            }
        })
        .off('click', '.player-remove')
        .on('click', '.player-remove', function(){
            var scoreTeam1 = $('.home-score').attr('data-teamid');
            var scoreTeam2 = $('.away-score').attr('data-teamid');   
            var $row = $(this).closest('.scorer');
            var scorerbox = $('.modresult-addscore').find('.scorer');
            var target = $(this).closest('.scorer').find('input[data-team]');
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
            $('#editMatchForm')
                .formValidation('removeField', $row.find('[name="playername[]"]'))
                .formValidation('removeField', $row.find('[name="time[]"]'));
            setTimeout(function() {
                $row.animateCss('slideOutRight', function (obj) {
                    obj.remove();
                    $('.modal .modal-body-custom').getNiceScroll().resize();
                    if(scorerbox.length === 2){$('.no-scorers-wrap').show();}
                });
            }, 400);
        })
        .off('click', '.event-player-remove')
        .on('click', '.event-player-remove', function(){
            var $row = $(this).closest('.event');
            var eventbox = $('.modresult-addevent').find('.event');
            $('#editMatchForm')
                .formValidation('removeField', $row.find('[name="eventplayername[]"]'))
                .formValidation('removeField', $row.find('[name="timevent[]"]'));
            setTimeout(function() {
                $row.animateCss('slideOutRight', function (obj) {
                    obj.remove();
                    $('.modal .modal-body-custom').getNiceScroll().resize();
                    if(eventbox.length === 2){$('.no-events-wrap').show();}
                });
            }, 400);
        })
        .off('click', '.walkover-team-remove')
        .on('click', '.walkover-team-remove', function(){
            $('.add-walkover .add-link').attr('disabled', false);
            var $row = $(this).closest('.walkover');
            var scoreTeam1 = $('.home-score').attr('data-teamid');
            var scoreTeam2 = $('.away-score').attr('data-teamid');   
            var sum1 = 0;
            var sum2 = 0;
            $('input[data-team="'+scoreTeam1+'"]').each(function(){
                sum1 += Number($(this).val());
            });
            homeScore.val(sum1);
            $('input[data-team="'+scoreTeam2+'"]').each(function(){
                sum2 += Number($(this).val());
            });
            awayScore.val(sum2);
            $('#editMatchForm')
                .formValidation('removeField', $row.find('[name="walkoverteamname"]'));
            setTimeout(function() {
                $row.remove();
                $('.modal .modal-body-custom').getNiceScroll().resize();
                $('.no-walkover-wrap').show();
                $('.no-walkover-wrap img').show();
                $(".modresult-addevent").slideDown(200);
                $(".modresult-addscore").slideDown(200);
            }, 800);
        })
        .on('err.field.fv', function(e, data) {
            data.element
                .data('fv.messages')
                .find('.help-block[data-fv-for="' + data.field + '"]').hide();
        })
        .off('success.form.fv')
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
                    success: function(response) {
                        $('.modal-content').waitMe("hide");
                        fv.disableSubmitButtons(false);
                        if(response.success){
                            showscore = response.showscore;
                            var newdata = ({
                                match_matchday: showscore.matchday,
                                match_id: showscore.matchid,
                                team1: showscore.team1,
                                score: '<a href="javascript:editMatch('+showscore.matchid+')"><strong>'+showscore.homescore+' - '+showscore.awayscore+'</strong></a>',
                                team2: showscore.team2
                            });
                            var nodeTeamtable = fixturetable.row('#'+ showscore.matchid +'').data(newdata).draw().node();
                            $(nodeTeamtable).effect('highlight', {color: "#e8f0fe"}, 3000);
                        }
                        $form.parents('.bootbox').modal('hide');
                        $.notify({message: updateSuccessMessage});
                    }
                });
            }, 600); 
        });
    }    
    if('undefined' !== typeof matchid){
        $.ajax({
            url: base+ 'admin/competitions/edit_league/select_match',
            type: 'POST',
            data: 'matchid=' + matchid, 
            success: function(response){
                if(response.success){
                    edatamatch = response.datamatch;
                    $('#team-one').html(edatamatch.team1);
                    $('#team-two').html(edatamatch.team2);
                    $('#compare-team-one').html(compareText(edatamatch.team1,edatamatch.team2));
                    $('#compare-team-two').html(edatamatch.team2.substr(0,3));
                    $('#logo-one').attr('src', base +'assets/img/teams_logo/'+edatamatch.logo1);
                    $('#logo-two').attr('src', base +'assets/img/teams_logo/'+edatamatch.logo2);
                    $(homeScore).val(edatamatch.score1);
                    $(awayScore).val(edatamatch.score2);
                    $('.home-score').attr('data-teamid', edatamatch.team1id);
                    $('.away-score').attr('data-teamid', edatamatch.team2id);
                    $('#matchid, #ematchid').val(edatamatch.matchid);
                    $('#competitionid').val(edatamatch.competitionid);
                }
            }
        });
            
        $('.assignedresult-scorer').html('');
        $.ajax({
            url: base + "admin/competitions/edit_league/select_scorers",
            type: 'POST',
            data: 'match_id=' + matchid,
            success: function(response) {
                if(response.success){
                    datascorers = response.datascorers;
                    if(!datascorers.length){                           
                        $('.no-scorers-wrap').show();
                    }else{
                        $('.no-scorers-wrap').hide();
                    }
                    $.each(datascorers, function(i, val){
                        div = '<div class="scorer">'+
                                '<div class="scorer-container" style="background-color: #eee">'+
                                    '<input id="goalscore" data-team="'+val.teamid+'" name="goalscore[]" type="hidden" value="1">'+
                                    '<div class="playername form-group">'+
                                        '<div class="icon"><i class="fa fa-male"></i></div>'+
                                        '<div class="infoscorer">'+
                                            '<span>'+val.playername+'</span>'+ 
                                            '<input type="hidden" name="teamidval[]" value="'+val.teamid+'">'+
                                            '<input type="hidden" name="playername[]" value="'+val.playerid+','+val.teamid+'">'+
                                        '</div>'+
                                        '<div class="owngoal">'+
                                            '<div class="icon">'+
                                                '<i class="fa fa-soccer-ball-o"></i>'+
                                            '</div>'+
                                            '<div class="infogoal">'+
                                                '<span>'+val.owngoal+'</span>'+ 
                                                '<input type="hidden" name="owngoal[]" value="'+val.owngoalid+'">'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="timescore form-group">'+
                                        '<div class="timelabel">Min</div>'+
                                        '<input class="form-control timescore" name="time[]" type="text" maxlength="3" value="'+val.timescore+'">'+
                                    '</div>'+
                                    '<div class="player-remove withripple" style="display: block;"><i class="material-icons">clear</i></div>'+
                                '</div>'+
                              '</div>';
                         $('.assignedresult-scorer').append(div);
                    });
                }
            }
        }); 
            
        $('.assignedresult-event').html('');
        $.ajax({
            url: base + "admin/competitions/edit_league/select_events",
            type: 'POST',
            data: 'match_id=' + matchid,
            success: function(response) {
                if(response.success){
                    dataevents = response.dataevents;
                    if(!dataevents.length){                           
                        $('.no-events-wrap').show();
                    }else{
                        $('.no-events-wrap').hide();
                    }
                    $.each(dataevents, function(i, val){
                        div = '<div class="event">'+
                            '<div class="event-container" style="background-color: #eee">'+
                                '<div class="eventplayername form-group">'+
                                    '<div class="icon"><i class="fa fa-male"></i></div>'+
                                    '<div class="infoscorer">'+
                                        '<span>'+val.playername+'</span>'+ 
                                        '<input type="hidden" name="evteamidval[]" value="'+val.teamid+'">'+
                                        '<input type="hidden" name="eventplayername[]" value="'+val.playerid+'">'+
                                    '</div>'+
                                    '<div class="playerevent">'+
                                            '<div class="icon">'+
                                                    '<i class="fa fa-calendar-o"></i>'+
                                            '</div>'+
                                            '<div class="infoevent">'+
                                                '<span>'+val.eventdesc+'</span>'+
                                                '<input type="hidden" name="eventype[]" value="'+val.eventid+'">'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="timevent form-group">'+
                                        '<div class="timelabel">Min</div>'+
                                        '<input class="form-control timescore" name="timevent[]" type="text" maxlength="3" value="'+val.timevent+'">'+
                                    '</div>'+
                                    '<div class="event-player-remove withripple" style="display: block;"><i class="material-icons">clear</i></div>'+
                                '</div>'+
                            '</div>';
                        $('.assignedresult-event').append(div);
                    });
                }
            }
        });    
                      
        bootbox.dialog({
            message: $('#editMatchForm'),
            closeButton: false,
            show: false,
            className:'bootbox-matchplay',
            animate: true,
            buttons:{
                submit:{
                    label: formButtonSave,
                    className: "btn-info",
                    callback: function(e) {
                        editmatch.submit();
                        return false;
                    }
                },
                cancel: {
                    label: formButtonClose,
                    className: "btn-info",
                     callback: function(e) {
                        $('.bootstrap-select').removeClass('open');
                        $('#editMatchForm').formValidation('revalidateField', 'playername[]');
                        $('#editMatchForm').formValidation('revalidateField', 'time[]');
                        $('#editMatchForm').formValidation('revalidateField', 'eventplayername[]');
                        $('#editMatchForm').formValidation('revalidateField', 'timevent[]');
                        $('#editMatchForm').formValidation('revalidateField', 'walkoverteamname');
                    }
                }
            }
        }).on('shown.bs.modal', function(){
            $('#editMatchForm').show();
            $('#editMatchForm').formValidation();
            $(".modresult-addevent").show();
            $(".modresult-addscore").show();
            var scorer =  $('.modresult-scorer .scorer');
            if((scorer).is(':visible')){
                $('.modresult-scorer .scorer').not('.scorer.hide').detach();
            }
            var event =  $('.modresult-event .event');
            if((event).is(':visible')){
                $('.modresult-event .event').not('.event.hide').detach();
            }
            var walkover =  $('.modresult-walkover .walkover');
            $(walkover).not('.walkover.hide').detach();
            $('.add-walkover .add-link').attr('disabled', false);
            $('.no-walkover-wrap').show();
            $('.no-walkover-wrap img').show();
            $('.modal .modal-body-custom').niceScroll({
                cursorwidth: '4px',
                cursorborder: '0px',
                cursorcolor: 'trasparent',
                railalign: 'right'
            });  
        }).on('hide.bs.modal', function(e){
            $('.selectscorer').selectpicker('hide');
            $('#editMatchForm').hide().appendTo('body');
        }).modal('show');
    }
}

/* Show users list */
function usersListTable() {
    if($('#userList').length && $.fn.DataTable) {
        var getdetails = $('#main-wrapper').find('input[name="getdetails"]').val();
        if(getdetails == '0') {
            var tabledetails = 'column';
            var detailsvisible = $.fn.dataTable.Responsive.display.childRowImmediate;
        } else {
            var tabledetails = 'inline';
            var detailsvisible = $.fn.dataTable.Responsive.display.childRow;
        }
        $.fn.dataTable.moment('DD/MM/YYYY');
        $.fn.dataTable.moment(tableDateTimeFormat);
        $('#userList').DataTable({
            serverMethod: "GET",
            ajaxSource: base + "admin/users/users_list/showusers",
            rowId: 'user_id',
            order: [0, "desc"],
            responsive: {
                details: {
                    display: detailsvisible,
                    type: tabledetails
                }
            },
            aoColumns: [
                {data: "user_id", bVisible: false},
                {className: 'all', data: null,
                    render: function(data, type, row) {
                        if(data.user_permissions === '4') {
                            return '<span class="text-lt">' + data.user_name + '</span>';
                        } else {
                            return data.user_name;
                        }
                    }
                },
                {data: "user_email"},
                {data: null,
                    render: function(data, type, row) {
                        if(data.user_permissions === '1') {
                            return '<span class="label label-orange">' + selectUG1 + '</span>';
                        } else if(data.user_permissions === '2') {
                            return '<span class="label label-primary">' + selectUG2 + '</span>'
                        } else if(data.user_permissions === '3') {
                            return '<span class="label label-success">' + selectUG3 + '</span>'
                        } else if(data.user_permissions === '4') {
                            return '<span class="label label-danger">' + selectUG4 + '</span>'
                        }
                    }
                },
                {data: "user_registration_date",
                    render: function(data, type, row) {
                        return(moment(data).format("DD/MM/YYYY"));
                    }
                },
                {data: "time",
                    render: function(data, type, row) {
                        return(moment(data).format(tableDateTimeFormat));
                    }
                },
                {bSortable: false, data: "action"}
            ]
        });
    }
}

/* Add users */
function addUser() {
    var usertable = $('#userList').DataTable();
    if($('#registerForm').length && $.fn.formValidation) {
        $('#inputBirthday').focus(function() {
        $(this).attr('placeholder', '__/__/____');
        }).blur(function() {
        $(this).attr('placeholder', '');
        });
        $('#registerForm').formValidation({
            framework: "bootstrap",
            button: {
                selector: '#btnRegisterForm',
                disabled: 'disabled'
            },
            locale: cklocal,
            live: 'submitted',
            fields: {
                username: {
                    validators: {
                        remote: {
                            message: ckusername,
                            url: base + 'admin/users/users_list/check_username',
                            type: 'POST'
                        },
                        notEmpty: {},
                        stringLength: {
                            min: 4,
                            max: 30
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/
                        }
                    }
                },
                email: {
                    validators: {
                        remote: {
                            message: ckemail,
                            url: base + 'admin/users/users_list/check_email',
                            type: 'POST'
                        },
                        notEmpty: {},
                        emailAddress: {},
                        regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$'
                        }
                    }
                },
                birthday: {
                    validators: {
                        notEmpty: {},
                        date: {
                            format: 'DD/MM/YYYY'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 4,
                            max: 20
                        }
                    }
                }
            }
        })
        .find('[name="birthday"]').mask('00/00/0000').end()
        .on('err.validator.fv', function(e, data) {
            if((data.field === 'email') || (data.field === 'password') || (data.field === 'birthday') || (data.field === 'username')) {
                data.element
                    .data('fv.messages')
                    .find('.help-block[data-fv-for="' + data.field + '"]').hide()
                    .filter('[data-fv-validator="' + data.validator + '"]').show();
            }
        })
        .off('success.form.fv')
        .on('success.form.fv', function(e) {
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
                    success: function(response) {
                        if(response.success) {
                            $('.modal-content').waitMe("hide");
                            fv.disableSubmitButtons(false);
                            newuser = response.adduser;
                            var nodeUsertable = usertable.row.add({
                                "user_id": newuser.userid,
                                "user_name": newuser.username,
                                "user_email": newuser.usermail,
                                "user_permissions": newuser.permission,
                                "user_registration_date": newuser.regdate,
                                "time": newuser.activity,
                                "action": '<a href="javascript:editUser('+ newuser.userid +')" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">\
                                           <i class="material-icons">mode_edit</i>\
                                           </a>\
                                           <a href="#" id="' + newuser.userid + '" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg delete">\
                                           <i class="material-icons">delete</i>\
                                           </a>'
                            }).draw().node();
                            $(nodeUsertable).addClass('animated fadeIn');
                            $(nodeUsertable).effect('highlight', {color: "#e8f0fe"}, 3000);
                        }
                        $form.formValidation('resetForm', true);
                        $form.parents('.bootbox').modal('hide');
                        $.notify({message: userAddSuccess});
                    }
                });
            },   600); 
        });
    }
    $('#addUser').on('click', function() {
        bootbox.dialog({
            message: $('#registerForm'),
            className:'bootbox-form',
            show: false,
            closeButton: false
        }).on('shown.bs.modal', function() {
            $('#registerForm').show();
            $('.form-group:first-child input').focus();
        }).on('hide.bs.modal', function(e) {
            $('#registerForm').hide().appendTo('body');
        }).modal('show');
    });
}

/* Edit user */
function editUser(userid){
    if($('#editUserForm').length && $.fn.formValidation){
        var userstable = $('#userList').DataTable();
        $('#editInputBirthday').focus(function() {
            $(this).attr('placeholder', '__/__/____');
            }).blur(function() {
            $(this).attr('placeholder', '');
            });
        $('#editUserForm').formValidation({
            framework: "bootstrap",
            button: {
                selector: '#btnEditUserForm',
                disabled: 'disabled'
            },
            locale: cklocal,
            live: 'submitted',
            fields: {
                username: {           
                    validators: {
                        remote: {
                            message: ckusername,
                            url: '../users/users_list/echeck_username',
                            data: function(validator, $field, value){
                                return{
                                    userid: validator.getFieldElements('userid').val()
                                };
                            },
                            type: 'POST'                        
                        },  
                        notEmpty: {},
                        stringLength: {                
                            min:4,
                            max:30
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/
                        }           
                    }
                },
                email: {
                    validators: {
                        remote: {
                            message: ckemail,
                            url: '../users/users_list/echeck_email',
                            data: function(validator, $field, value){
                                return{
                                    userid: validator.getFieldElements('userid').val()
                                };
                            },
                            type: 'POST'
                        },    
                        notEmpty: {},
                        emailAddress: {},
                        regexp: {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$'                           
                        }
                    }
                },
                newpassword: {
                    enabled: false,
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 4,
                            max: 20
                        }
                    }
                },
                birthday: {
                    validators: {
                        notEmpty: {},
                        date: {
                            format: 'DD/MM/YYYY'                        
                        }
                    }
                }        
            }
        })
        .find('[name="birthday"]').mask('00/00/0000').end()
        .on('keyup', '[name="newpassword"]', function(){
            var isEmpty = $(this).val() === '';
            $('#editUserForm').formValidation('enableFieldValidators', 'newpassword', !isEmpty);
            if($(this).val().length === 1){
                $('#editUserForm').formValidation('validateField', 'newpassword');
            }    
        })
        .on('err.validator.fv', function(e, data) {
            if ((data.field === 'username')||(data.field === 'email')||(data.field === 'birthday')) {
                data.element
                .data('fv.messages')
                .find('.help-block[data-fv-for="' + data.field + '"]').hide()
                .filter('[data-fv-validator="' + data.validator + '"]').show();
            }
        })
        .off('success.form.fv')
        .on('success.form.fv',function(e){
            $('.modal-content').waitMe({
                effect: '',
                bg: 'rgba(255,255,255,0.7)',
                color: '#f44336'
            });
            e.preventDefault();
            var $form = $(e.target),
            fv = $form.data('formValidation');
            setTimeout(function(){
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        $('.modal-content').waitMe("hide");
                        fv.disableSubmitButtons(false);
                        if(response.success){
                            updateuser = response.edituser;
                            var newdata = ({
                                user_id: updateuser.userid,
                                user_name: updateuser.username,
                                user_email: updateuser.useremail,
                                user_permissions: updateuser.permission,
                                user_registration_date: updateuser.regdate,
                                action: '<a href="javascript:editUser('+  updateuser.userid +')" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">\
                                         <i class="material-icons">mode_edit</i>\
                                         </a>\
                                         <a href="#" id="' +  updateuser.userid + '" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg delete">\
                                         <i class="material-icons">delete</i>\
                                         </a>'
                            });
                            var nodeUserstable = userstable.row('#'+ updateuser.userid +'').data(newdata).draw().node();
                            $(nodeUserstable).effect('highlight', {color: "#e8f0fe"}, 3000);
                        }
                        $form.parents('.bootbox').modal('hide');
                        $.notify({message: updateSuccessMessage});
                    }
                });
            }, 600); 
        });
    }
        
    if('undefined' !== typeof userid){
        var selectpermission = $('#editSelectPermission');
        selectpermission.html('');
        $('#editInputPassword').val('');
        $.ajax({
            url: 'users_list/select_user',
            type: 'POST',
            data: 'userid=' + userid, 
            success: function(response){
                if(response.success){
                    edatauser = response.datauser;
                    var selected = edatauser.userpermission;
                    var permission = '<option value="1">'+ selectUG1 +'</option>\
                                      <option value="2">'+ selectUG2 +'</option>\
                                      <option value="3">'+ selectUG3 +'</option>\
                                      <option value="4">'+ selectUG4 +'</option>';
                    var birthday = moment(edatauser.userbirthday).format('DD/MM/YYYY');
                    $('#editUserId').val(edatauser.userid);
                    $('#editInputUsername').val(edatauser.username);
                    $('#editInputEmail').val(edatauser.useremail);
                    $('#hiddenPassword').val(edatauser.userpassword);
                    $('#editInputBirthday').val(birthday);
                    selectpermission.append(permission).selectpicker('refresh');
                }
                $('#editSelectPermission option').each(function(){
                    if($(this).val()=== selected){
                        $(this).attr('selected', 'selected');
                    }
                });
                selectpermission.selectpicker('refresh');
            }
        });
        bootbox.dialog({
            message: $('#editUserForm'),
            className: 'bootbox-form',
            show: false,
            closeButton: false
        }).on('shown.bs.modal', function(){
            $('#editUserForm').show().formValidation('resetForm');
        }).on('hide.bs.modal', function(e){
            $('#editUserForm').hide().appendTo('body');
        }).modal('show');
    }
}

/* Delete users */
function userDelete() {
    $('#userList').on('click', '.delete', function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var childshow = $(this).parents(".child");
        if((childshow).length) {
            var parent = $(this).parents("tr").prev();
        } else {
            var parent = $(this).parents("tr");
        }
        var usertable = $('#userList').DataTable();
        bootbox.dialog({
            message: alertMessageDeleteUser,
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
                url: 'users_list/deleteuser',
                type: 'POST',
                data: 'id=' + id,
                success: function(result) {
                    if(result == '') {
                        $(parent).effect('highlight', {color: "#e8f0fe"}, 1000, function() {
                            $(parent).fadeOut('slow', function() {
                                usertable.row(parent).remove().draw(false);
                            });
                        });
                        $.notify({message: userDeleteSuccess});
                    }
                }
            });
        }
    });
}

/* Show teams list */
function teamsListTable() {
    if($('#teamsList').length && $.fn.DataTable) {
        var getdetails = $('#main-wrapper').find('input[name="getdetails"]').val();
        if(getdetails == '0') {
            var tabledetails = 'column';
            var detailsvisible = $.fn.dataTable.Responsive.display.childRowImmediate;
        } else {
            var tabledetails = 'inline';
            var detailsvisible = $.fn.dataTable.Responsive.display.childRow;
        }
        $.fn.dataTable.moment('DD/MM/YYYY');
        $('#teamsList').DataTable({
            serverMethod: "GET",
            ajaxSource: base + "admin/teams/teams_list/showteams",
            rowId: 'team_id',
            responsive: {
                details: {
                    display: detailsvisible,
                    type: tabledetails
                }
            },
            order: [0, "desc"],
            aoColumns: [
                {data: "team_id", bVisible: false},
                {className: 'all', data: "teaminfo"},
                {data: "user_name",
                    render: function(data, type, full, meta) {
                        if(data === null) {
                            return '<a href="' + base + 'admin/managers/managers_list" class="animsition-link table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">\
                                    <i class="material-icons">add</i>\
                                    </a>';
                        } else {
                            return data;
                        }
                    }
                },
                {data: "manager_wallet"},
                {data: "team_registration_date",
                    render: function(data, type, row) {
                        return(moment(data).format("DD/MM/YYYY"));
                    }
                },
                {bSortable: false, data: "action"}
            ]
        });
    }
}

/* Add team */
function addTeam(){
    var teamstable = $('#teamsList').DataTable();
    if($('#addTeamForm').length && $.fn.formValidation){
        $('.rating-remove').on('click', function(){
        $('.form-group').find('#inputLevel').rating('rate', 0);
        });
        $('#addTeamForm').formValidation({
            framework: "bootstrap",
            button: {
                selector: '#btnAddTeamForm',
                disabled: 'disabled'
            },
            locale: cklocal,
            live: 'submitted',
            fields: {
                teamname: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 2,
                            max: 30
                        }
                    }
                }
            }
        })
        .on('err.validator.fv', function(e, data) {
            if((data.field === 'teamname')) {
                data.element
                .data('fv.messages')
                .find('.help-block[data-fv-for="' + data.field + '"]').hide()
                .filter('[data-fv-validator="' + data.validator + '"]').show();
            }
        })
        .on('success.form.fv', function(e) {
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
                    success: function(response) {
                        $('.modal-content').waitMe("hide");
                        fv.disableSubmitButtons(false);
                        if(response.success) {
                            newteam = response.addteam;
                            var nodeTeamtable = teamstable.row.add({
                                team_id: newteam.teamid,
                                teaminfo: '<img src="../../assets/img/teams_logo/' + newteam.teamlogo + '">\
                                           <span class="img-cell">' + newteam.teamname + '</span>\
                                           <span class="icon-cell"><input type="hidden" class="form-control rating" id="inputLevel" name="teamlevel" data-filled="fa fa-star" data-empty="fa fa-star-o" data-readonly value="' + newteam.teamlevel + '"></span>',
                                user_name: null,
                                manager_wallet: "0",
                                team_registration_date: newteam.regdate,
                                action: '<a href="javascript:editTeam('+ newteam.teamid +')" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">\
                                         <i class="material-icons">mode_edit</i>\
                                         </a>\
                                         <a href="#" id="' + newteam.teamid + '" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg delete">\
                                         <i class="material-icons">delete</i>\
                                         </a>'
                            }).draw().node();
                            $(nodeTeamtable).addClass('animated fadeIn');
                            $(nodeTeamtable).effect('highlight', {color: "#e8f0fe"}, 3000);
                            $.notify({message: teamAddSuccess});
                        }
                        $form.parents('.bootbox').modal('hide');
                    }
                });
            }, 600); 
        });
    }
    $('#addTeam').on('click', function() {
        bootbox.dialog({
            message: $('#addTeamForm'),
            className:'bootbox-form',
            show: false,
            closeButton: false
        }).on('shown.bs.modal', function() {
            $('#addTeamForm').show()
                .formValidation('resetForm', true);
            $('.form-group:first-child input').focus();    
        }).on('hide.bs.modal', function(e) {
            $('#addTeamForm').hide().appendTo('body');
        }).modal('show');
    });
}

/* Edit team */
function editTeam(teamid){
    if($('#editTeamForm').length && $.fn.formValidation){
        $('.rating-remove').click(function(){
            $('#editInputLevel').rating('rate', 0);
        });
        $('#image-preview').attr('data-id', teamid);
        var teamstable = $('#teamsList').DataTable();
        $('#editTeamForm').formValidation({
            framework: "bootstrap",
            button: {
                selector: '#btnEditTeamForm',
                disabled: 'disabled'
            },
            locale: cklocal,
            live: 'submitted',
            fields: {
                teamname: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 2,
                            max: 30
                        }
                    }
                }
            }
        })
        .on('err.validator.fv', function(e, data) {
            if((data.field === 'teamname')) {
                data.element
                    .data('fv.messages')
                    .find('.help-block[data-fv-for="' + data.field + '"]').hide()
                    .filter('[data-fv-validator="' + data.validator + '"]').show();
            }
        })
        .off('success.form.fv')
        .on('success.form.fv', function(e) {
            $('.modal-content').waitMe({
                effect: '',
                bg: 'rgba(255,255,255,0.7)',
                color: '#f44336'
            });
            e.preventDefault();
            var $form = $(e.target),
            fv = $form.data('formValidation');    
            setTimeout(function(){
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        $('.modal-content').waitMe("hide");
                        fv.disableSubmitButtons(false);
                        if(response.success){
                            updateteam = response.editeam;
                            var newdata = ({
                                team_id: updateteam.teamid,
                                teaminfo: '<img src="../../assets/img/teams_logo/' +  updateteam.teamlogo + '">\
                                           <span class="img-cell">' +  updateteam.teamname + '</span>\
                                           <span class="icon-cell"><input type="hidden" class="form-control rating" id="inputLevel" name="teamlevel" data-filled="fa fa-star" data-empty="fa fa-star-o" data-readonly value="' +  updateteam.teamlevel + '"></span>',
                                user_name: updateteam.username,
                                manager_wallet: "0",
                                team_registration_date: updateteam.regdate,
                                action: '<a href="javascript:editTeam('+  updateteam.teamid +')" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">\
                                         <i class="material-icons">mode_edit</i>\
                                         </a>\
                                         <a href="#" id="' +  updateteam.teamid + '" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg delete">\
                                         <i class="material-icons">delete</i>\
                                         </a>'
                            });
                            var nodeTeamtable = teamstable.row('#'+ updateteam.teamid +'').data(newdata).draw().node();
                            $(nodeTeamtable).effect('highlight', {color: "#e8f0fe"}, 3000);
                        }
                        $form.parents('.bootbox').modal('hide');
                        $.notify({message: updateSuccessMessage});
                    }
                });
            }, 600); 
        });
    }
    
    if('undefined' !== typeof teamid){
        $.ajax({
            url: 'teams_list/select_team',
            type: 'POST',
            data: 'teamid=' + teamid, 
            success: function(response){
                if(response.success){
                    edatateam = response.datateam;
                    if(edatateam.teamlogo.substring(0, 4) === 'https'){
                        $('#thumbImg').attr('src', edatateam.teamlogo);    
                    }else{
                        $('#thumbImg').attr('src', base+'assets/img/teams_logo/'+ edatateam.teamlogo +'');
                    }
                    $('#editTeamId').val(edatateam.teamid);
                    $('#editInputTeamname').val(edatateam.teamname);
                    $('#editInputLevel').rating('rate', edatateam.teamlevel);
                }
            }
        });
        
        bootbox.dialog({
           message: $('#editTeamForm'),
           className: 'bootbox-form',
           show: false,
           closeButton: false
        }).on('shown.bs.modal', function(){
            $('#editTeamForm').show().formValidation('resetForm');
        }).on('hide.bs.modal', function(e){
            $('#editTeamForm').hide().appendTo('body');
        }).modal('show');
    }
}

/* Delete team */
function teamDelete() {
        $('#teamsList').on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var childshow = $(this).parents(".child");
            if((childshow).length) {
                var parent = $(this).parents("tr").prev();
            } else {
                var parent = $(this).parents("tr");
            }
            var teamstable = $('#teamsList').DataTable();
            bootbox.dialog({
                message: alertMessageDeleteTeam,
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
                    url: 'teams_list/delete_team',
                    type: 'POST',
                    data: 'id=' + id,
                    success: function(result) {
                        if(result == '') {
                            $(parent).effect('highlight', {color: "#e8f0fe"}, 1000, function() {
                                $(parent).fadeOut('slow', function() {
                                    teamstable.row(parent).remove().draw(false);
                                });
                            });
                            $.notify({message: teamDeleteSuccess});
                        }
                    }
                });
            }
        });
    }

/* Show managers list */
function managersListTable() {
        if($('#managersList').length && $.fn.DataTable) {
            var getdetails = $('#main-wrapper').find('input[name="getdetails"]').val();
            if(getdetails == '0') {
                var tabledetails = 'column';
                var detailsvisible = $.fn.dataTable.Responsive.display.childRowImmediate;
            } else {
                var tabledetails = 'inline';
                var detailsvisible = $.fn.dataTable.Responsive.display.childRow;
            }
            $.fn.dataTable.moment('DD/MM/YYYY');
            $('#managersList').DataTable({
                serverMethod: "GET",
                ajaxSource: base + "admin/managers/managers_list/showmanagers",
                responsive: {
                    details: {
                        display: detailsvisible,
                        type: tabledetails
                    }
                },
                order: [0, "desc"],
                columnDefs: [
                    {"type": "num-fmt", "targets": 3}
                ],
                aoColumns: [
                    {data: "manager_id", bVisible: false},
                    {data: "user_name", className: 'all'},
                    {data: null,
                        render: function(data, type, row, meta) {
                            if(!data.team_name) {
                                return '<a href="' + base + 'admin/managers/edit_manager/managerid/' + data.manager_id + '" class="animsition-link table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">\
                                        <i class="material-icons">add</i>\
                                        </a>';
                            } else {
                                return data.team_name;
                            }
                        }
                    },
                    {data: "manager_wallet",
                        render: function(data, type, row) {
                            return $.number(data, '0', '', mask)
                        }
                    },
                    {data: "manager_registration_date",
                        render: function(data, type, row) {
                            return(moment(data).format("DD/MM/YYYY"));
                        }
                    },
                    {bSortable: false, data: "action"}
                ]
            });
        }
    }

/* Add manager */
function addManager() {
        var managerstable = $('#managersList').DataTable();
        if($('#addManagerForm').length && $.fn.formValidation) {
            $('#addManagerForm').find('[name="username"]').selectpicker().change(function(e) {
                    $('#addManagerForm').formValidation('revalidateField', 'username');
                })
                .end();
            $('#addManagerForm').find('[name="teamname"]').selectpicker().change(function(e) {
                    $('#addManagerForm').formValidation('revalidateField', 'teamname');
                })
                .end();
            $('#addManagerForm').formValidation({
                    framework: "bootstrap",
                    button: {
                        selector: '#btnAddManagerForm',
                        disabled: 'disabled'
                    },
                    excluded: 'disabled',
                    locale: cklocal,
                    live: 'submitted',
                    fields: {
                        username: {
                            validators: {
                                notEmpty: {}
                            }
                        },
                        teamname: {
                            validators: {
                                notEmpty: {}
                            }
                        }
                    }
                })
                .on('err.validator.fv', function(e, data) {
                    if((data.field === 'username') || (data.field === 'teamname')) {
                        data.element
                            .data('fv.messages')
                            .find('.help-block[data-fv-for="' + data.field + '"]').hide()
                            .filter('[data-fv-validator="' + data.validator + '"]').show();
                    }
                })
                .on('success.form.fv', function(e) {
                    $('.modal-content').waitMe({
                        effect: 'rotation',
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
                            success: function(response) {
                                if(response.success) {
                                    $('.modal-content').waitMe("hide");
                                    fv.disableSubmitButtons(false);
                                    newmanager = response.addmanager;
                                    var nodeManagertable = managerstable.row.add({
                                        "manager_id": newmanager.managerid,
                                        "user_name": newmanager.username,
                                        "team_name": newmanager.teamname,
                                        "manager_wallet": newmanager.wallet,
                                        "action": '<a href="' + base + 'admin/managers/edit_manager/managerid/' + newmanager.managerid + '" class="animsition-link table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">\
                                                   <i class="material-icons">mode_edit</i>\
                                                   </a>\
                                                   <a href="#" id="' + newmanager.managerid + '" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg delete">\
                                                   <i class="material-icons">delete</i>\
                                                   </a>'
                                    }).draw().node();
                                    $(nodeManagertable).addClass('animated fadeIn');
                                    $(nodeManagertable).effect('highlight', {color: "#e8f0fe"}, 3000);
                                    $.notify({message: managerAddSuccess});
                                }
                                $form.parents('.bootbox').modal('hide');
                            }
                        });
                    },   600); 
                });
        }
        $('#addManager').on('click', function() {
            bootbox.dialog({
                message: $('#addManagerForm'),
                show: false,
                className:'bootbox-form',
                closeButton: false
            }).on('shown.bs.modal', function() {
                $('#addManagerForm').show()
                .formValidation('resetForm', true);
            }).on('hide.bs.modal', function(e) {
                $('#addManagerForm').hide().appendTo('body');
            }).modal('show');
            
            $selectUsers = $('#selectUsername');
            $selectUsers.html('');
            $.ajax({
                url: base + "admin/managers/managers_list/loadusers",
                dataType: 'JSON',
                success: function(response) {
                    $.each(response.userslist, function(key, val) {
                        $selectUsers.append('<option value="' + val.userid + '">' + val.username + '</option>').selectpicker('refresh');
                    });
                }
            });

            $selectTeams = $('#selectTeamname');
            $selectTeams.html('');
            $.ajax({
                url: base + "admin/managers/managers_list/loadteams",
                dataType: 'JSON',
                success: function(response) {
                    $.each(response.teamslist, function(key, val) {
                        $selectTeams.append('<option value="' + val.teamid + '">' + val.teamname + '</option>').selectpicker('refresh');
                    });
                }
            });
        });
    }

/* Delete manager */
function managerDelete() {
        $('#managersList').on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var childshow = $(this).parents(".child");
            if((childshow).length) {
                var parent = $(this).parents("tr").prev();
            } else {
                var parent = $(this).parents("tr");
            }
            var managerstable = $('#managersList').DataTable();
            bootbox.dialog({
                message: alertMessageDeleteManager,
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
                    url: 'managers_list/deletemanager',
                    type: 'POST',
                    data: 'id=' + id,
                    success: function(result) {
                        if(result == '') {
                            $(parent).effect('highlight', {color: "#e8f0fe"}, 1000, function() {
                                $(parent).fadeOut('slow', function() {
                                    managerstable.row(parent).remove().draw(false);
                                });
                            });
                            $.notify({message: managerDeleteSuccess});
                        }
                    }
                });
            }
        });
    }

/* Show players list */
function playersListTable() {
        if($('#playersList').length && $.fn.DataTable) {
            // initialize datatable
            $('#playersList').DataTable({
                serverSide: true,
                serverMethod: "GET",
                ajaxSource: base + "admin/players/players_list/showplayers",
                order: [0, "asc"],
                aoColumns: [
                    {bVisible: false},
                    {className: 'all', data: null,
                        render: function(data, type, row) {
                            return '<img src="' + row[9] + row[7] + '.png" onerror="imgError(this);">\
                            <span class="img-cell"><a href="' + row[8] + row[7] + '">' + row[1] + '</a></span>';
                        }
                    },
                    {data: 2,
                        render: function(data, type, row, meta) {
                            if(data === null) {
                                return '<a href="' + base + 'admin/players/edit_player/playerid/' + row[6] + '" class="animsition-link table-icon green-icon">\
                                <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-plus-circle fa-stack-1x fa-inverse"></i><span>';
                            } else {
                                return data;
                            }
                        }
                    },
                    null,
                    null,
                    null,
                    {bSortable: false, data: 6,
                        render: function(data, type, full, meta) {
                            return '<a href="' + base + 'admin/players/edit_player/playerid/' + data + '" class="animsition-link table-icon">\
                            <span class="fa-stack">\
                            <i class="fa fa-circle fa-stack-2x"></i>\
                            <i class="fa fa-edit fa-stack-1x fa-inverse"></i>\
                            </span>\
                            </a>\
                            <a href="#" id="' + data + '" class="table-icon red-icon delete">\
                            <span class="fa-stack">\
                            <i class="fa fa-circle fa-stack-2x"></i>\
                            <i class="fa fa-trash fa-stack-1x fa-inverse"></i>\
                            </span>\
                            </a>';
                        }
                    },
                    {bVisible: false},
                    {bVisible: false},
                    {bVisible: false}
                ]
            });
        }
    }
    

/* Init ajax function */
$(document).ajaxComplete(function() {
    if($('.rating').length) {
        $('.rating').rating();
    };
});

/* Init Functions */
$(document).ready(function() {
    leaguesListTable();
    addLeague();
    makeFixture();
    leagueDelete();
    fixtureListTable();
    usersListTable();
    addUser();
    userDelete();
    teamsListTable();
    addTeam();
    editTeam();
    teamDelete();
    managersListTable();
    addManager();
    managerDelete();
    playersListTable();
});