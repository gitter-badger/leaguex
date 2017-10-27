<form action="<?php echo site_url("admin/competitions/edit_league/updateResult");?>" method="post" role="form" name="editMatchForm" id="editMatchForm" autocomplete="off" novalidate="novalidate" class="fv-form fv-form-bootstrap" style="display:none;">
    <input type="hidden" id="matchid" name="matchid" value="">
    <input type="hidden" id="ematchid" name="vmatchid" value="">
    <input type="hidden" id="competitionid" name="competitionid" value="">
    <input type="hidden" id="matchdayid" name="matchdayid" value="">
    <div class="modal-header">
        <div class="modresult-box">
            <div class="modresult-match-info">
                <div class="modresult-team-one">
                    <span class="full-text" id="team-one"></span>
                    <span class="compare-text" id="compare-team-one"></span>
                    <span class="modresult-logo-container">
                        <span class="modresult-team-logo"><img class="team-logo-25" id="logo-one" src=""></span>
                    </span>
                </div>
                <div class="modresult-match-score"><span><input type="text" size="1" value="0" class="home-score" name="home-score" data-teamid=""> - <input type="text" size="1" value="0" class="away-score" name="away-score" data-teamid=""></span></div>
                <div class="modresult-team-two">
                    <span class="modresult-logo-container">
                        <span class="modresult-team-logo"><img class="team-logo-25" id="logo-two" src=""></span>
                    </span>
                    <span class="full-text" id="team-two"></span>
                    <span class="compare-text" id="compare-team-two"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-body-custom">
        <div class="row">
            <div class="col-sm-12">
                <div class="modresult-addscore">
                    <h5><?php echo lang('addresult_title_goal_scorers');?></h5>
                    <div class="modresult-scorer">
                        <div class="scorer hide" id="addresultTemplate">
                            <div class="scorer-container">
                                <input id="goalscore" data-team="" type="hidden" value="1"/>
                                <div class="playername form-group">
                                    <div class="icon"><i class="fa fa-male"></i></div>
                                    <select class="selectpicker show-tick selectscorer custom-dropdown" id="selectPlayerName" data-size="auto" data-width="fit" title="<?php echo lang('select_default');?>"></select>
                                    <input type="hidden" id="teamidval" value="">
                                    <div class="owngoal">
                                    <div class="icon"><i class="fa fa-soccer-ball-o"></i></div>    
                                    <select class="selectpicker selectowngoal custom-dropdown" id="owngoal" data-size="auto" data-width="fit">
                                        <option value="0"><?php echo lang('addresult_option_goal');?></option>
                                        <option value="1"><?php echo lang('addresult_option_own_goal');?></option>
                                    </select>
                                    </div>
                                </div>
                                <div class="timescore form-group">
                                    <div class="timelabel">Min</div>
                                    <input class="form-control" id="time" type="text" maxlength="3" value=""/>
                                </div>
                                <div class="player-remove withripple"><i class="material-icons">clear</i></div>
                            </div>
                        </div>
                        <div class="add-scorer">
                            <div class="scorer-container" style="background-color: #f1f1f1; box-shadow: none;">
                                <div class="add-link"><a href="javascript:void(0)"><?php echo lang('addresult_title_add_scorer');?></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="assignedresult-scorer"></div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="modresult-addevent">
                    <h5><?php echo lang('addresult_title_events');?></h5>
                    <div class="modresult-event">
                        <div class="event hide" id="addeventTemplate">
                            <div class="event-container">
                                <div class="eventplayername form-group">
                                    <div class="icon"><i class="fa fa-male"></i></div>
                                    <select class="selectpicker show-tick selectevent custom-dropdown" id="selectEventPlayerName" data-size="auto" data-width="fit" title="<?php echo lang('select_default');?>"></select>
                                    <input type="hidden" id="evteamidval" value="">
                                    <div class="playerevent form-group">
                                        <div class="icon"><i class="fa fa-calendar-o"></i></div>
                                        <select class="selectpicker selecteventype custom-dropdown" id="selectEvenType" data-size="auto" data-width="fit"></select>
                                    </div>
                                </div>
                                <div class="timevent form-group">
                                    <div class="timelabel">Min</div>
                                    <input class="form-control" id="timevent" type="text" maxlength="3" value=""/>
                                </div>
                                <div class="event-player-remove withripple"><i class="material-icons">clear</i></div>
                                <input id="eventscore" data-team="" type="hidden" value="1">
                            </div>
                        </div>
                        <div class="add-event">
                            <div class="event-container" style="background-color: #f1f1f1; box-shadow: none;">
                                <div class="add-link"><a href="javascript:void(0)"><?php echo lang('addresult_title_add_event');?></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="assignedresult-event"></div>
                </div>
            </div>
        </div>
    </div>
</form>   


