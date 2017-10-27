/*!
*   LEAGUEX
*   @copyright (C) 2014 fankstribe. All rights reserved.
*   @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*   License: Open source - MIT
*   @link http://www.fankstribe.org 
!*/

var $animsition = $('.animsition');

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

function fixturesTable(){
    $('#selectLeagues').on('change', function(e){
        e.preventDefault();
        var $elem = $(this);
        var $url = 'javascript:void(0)';
        var id = $('#selectLeagues').val();
        var matchdayNull = ''; 
        $('ul.matchlist').empty();
        $animsition.animsition('out', $elem, $url);
        $.ajax({
            url: base + "competitions/leagues/filterLeagues",
            type: "POST", 
            dataType: "JSON",
            data: {"id":id},
            success: function(data){
                $("#loading").hide();
                $.each(data, function(index, item){
                    var matchdayName = item.matchday_name; 
                    var manager = item.managerid; 
                    if(matchdayName !== matchdayNull){
                        var headtitle = '<li class="matchlist-heading"><div class="matchlist-competition-logo"><img src="'+ base +'assets/img/competitions_logo/'+item.competition_logo+'"></div><div class="matchlist-competition-name">'+item.competition_name+'&nbsp-&nbsp</div><div class="matchlist-day-title">'+leagueMatchdayTitle+' '+matchdayName+'</div></li>';
                    }else{
                        var headtitle = '';
                    } 
                    matchdayNull = matchdayName;
                    if((manager == item.teamid1 && item.match_status == 0)||(manager == item.teamid2 && item.match_status == 0)){
                        var matchon = '<span class="material-icons match-game">games</span>';
                    }else{
                        var matchon = item.score1 === null ? " - " : item.score1+ ' - ' +item.score2;
                    }
                    var list= ''+headtitle+'<li>\
                        <a href="'+base+'competitions/match/matchid/'+item.match_id+'" class="animsition-link fixture-wrap">\
                        <span class="fixture-match">\
                        <span class="fixture-teams">\
                        <span class="teams"><span class="team-name"><span class="full-text">'+item.team1+'</span><span class="compare-text">'+compareText(item.team1,item.team2)+'</span></span><span class="fixture-team-logo"><img src="'+base+'assets/img/teams_logo/'+item.logo1+'"></span></span><span class="match-score">'+matchon+'</span><span class="teams"><span class="team-name"><span class="full-text">'+item.team2+'</span><span class="compare-text">'+item.team2.substr(0,3)+'</span></span><span class="fixture-team-logo"><img src="'+base+'assets/img/teams_logo/'+item.logo2+'"></span></span>\
                        </span>\
                        </span>\
                        </a>\
                        </li>';
                    $('.matchlist').append(list);  
                });
                $('li.matchlist-heading').each(function(){
                    $(this).nextUntil('li.matchlist-heading').addBack().wrapAll('<div class="panel"><div class="panel-body"></div></div)'); 
                });
                $animsition.removeClass('fade-out-down-sm');
                $animsition.animsition('in');
            }
        }); 
    });
    
    $('#selectTeams').on('change', function(e){
        e.preventDefault();
        var $elem = $(this);
        var $url = 'javascript:void(0)';
        var teamid = $('#selectTeams').val();
        var id = $('#selectLeagues').val();
        var matchdayNull = '';
        $('ul.matchlist').empty();
        $animsition.animsition('out', $elem, $url);
        $.ajax({
            url: base + "competitions/leagues/filterTeams",
            type: "POST", 
            dataType: "JSON",
            data: {"id":id, "teamid":teamid},
            success: function(data){
                $.each(data, function(index, item){
                    var matchdayName = item.matchdayname;
                    var manager = item.managerid;
                    if(matchdayName !== matchdayNull){
                        var headtitle = '<li class="matchlist-heading"><div class="matchlist-competition-logo"><img src="'+ base +'assets/img/competitions_logo/'+item.competition_logo+'"></div><div class="matchlist-competition-name">'+item.competition_name+'&nbsp-&nbsp</div><div class="matchlist-day-title">'+leagueMatchdayTitle+' '+matchdayName+'</div></li>';
                    }else{
                        var headtitle = '';
                    } 
                    matchdayNull = matchdayName;
                    if((manager == item.teamid1 && item.match_status == 0)||(manager == item.teamid2 && item.match_status == 0)){
                        var matchon = '<span class="material-icons match-game">games</span>';
                    }else{
                        var matchon = item.score1 === null ? " - " : item.score1+ ' - ' +item.score2;
                    } 
                    var list= ''+headtitle+'\
                        <li>\
                        <a href="'+base+'competitions/match/matchid/'+item.match_id+'" class="animsition-link fixture-wrap">\
                        <span class="fixture-match">\
                        <span class="fixture-teams">\
                        <span class="teams"><span class="team-name"><span class="full-text">'+item.team1+'</span><span class="compare-text">'+compareText(item.team1,item.team2)+'</span></span><span class="fixture-team-logo"><img src="'+base+'assets/img/teams_logo/'+item.logo1+'"></span></span><span class="match-score">'+matchon+'</span><span class="teams"><span class="team-name"><span class="full-text">'+item.team2+'</span><span class="compare-text">'+item.team2.substr(0,3)+'</span></span><span class="fixture-team-logo"><img src="'+base+'assets/img/teams_logo/'+item.logo2+'"></span></span>\
                        </span>\
                        </span>\
                        </a>\
                        </li>';
                    $('.matchlist').append(list);
                });
                $('li.matchlist-heading').each(function(){
                    $(this).nextUntil('li.matchlist-heading').addBack().wrapAll('<div class="panel"><div class="panel-body"></div></div)'); 
                });
                $animsition.removeClass('fade-out-down-sm');
                $animsition.animsition('in');
            }
        });
    });
            
    $('#selectLeagues').on('change', function(){
        $('#selectTeams').find("option:gt(0)").remove();
        var id = $('#selectLeagues').val();
        $selectTeams = $('#selectTeams');
        $.ajax({
           type: 'POST', 
           url: base + "competitions/leagues/loadteams", 
           data: {"id":id},
           success: function(response) {
                $.each(response.teamslist, function(key, val) {
                    $selectTeams.append('<option value="' + val.teamid + '">' + val.teamname + '</option>').selectpicker('refresh');
                });
            }
        });
    });
    
    $selectLeagues = $('#selectLeagues');
    $.ajax({
        url: base + "competitions/leagues/loadleagues",
        dataType: 'JSON',
        success: function(response) {
            $.each(response.leagueslist, function(key, val) {
                $selectLeagues.append('<option value="' + val.leagueid + '">' + val.leaguename + '</option>').selectpicker('refresh');
            });
        }
    });
}

/****  Init functions  ****/
$(document).ready(function (){
    fixturesTable();
});