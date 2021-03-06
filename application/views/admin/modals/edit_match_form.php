<form action="<?php echo site_url("admin/competitions/edit_league/updateResult");?>" method="post" role="form" name="editMatchForm" id="editMatchForm" autocomplete="off" novalidate="novalidate" class="fv-form fv-form-bootstrap" style="display:none;">
    <input type="hidden" id="matchid" name="matchid" value="">
    <input type="hidden" id="ematchid" name="vmatchid" value="">
    <input type="hidden" id="competitionid" name="competitionid" value="">
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
                    <div class="add-scorer">
                        <div class="scorer-title m-r-a"><?php echo lang('addresult_title_goal_scorers');?></div>
                        <button type="button" class="add-link btn btn-fab btn-fab-mini no-shadow no-color-bg" id="morescorer"><i class="fa fa-refresh fa-spin" style="display: none"></i><i class="material-icons">add_circle</i></button>
                    </div>
                    <div class="no-scorers-wrap">
                        <div class="no-scorers-container animated fadeIn">
                            <div class="no-scorers"><img src="<?= base_url().'assets/img/no-scorer.png'?>" width="50px"></div>
                        </div>
                    </div>
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
                    </div>
                    <div class="assignedresult-scorer"></div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="modresult-addevent">
                    <div class="add-event">
                        <div class="event-title m-r-a"><?php echo lang('addresult_title_events');?></div>
                        <button type="button" class="add-link btn btn-fab btn-fab-mini no-shadow no-color-bg" id="morevents"><i class="fa fa-refresh fa-spin" style="display: none"></i><i class="material-icons">add_circle</i></button>
                    </div>
                     <div class="no-events-wrap">
                        <div class="no-events-container animated fadeIn">
                            <div class="no-events"><img src="<?= base_url().'assets/img/no-events.png'?>" width="45px"></div>
                        </div>
                    </div>
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
                    </div>
                    <div class="assignedresult-event"></div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="modresult-addwalkover">
                    <div class="add-walkover">
                        <div class="walkover-title m-r-a"><?php echo lang('addresult_title_walkover');?></div>
                        <button type="button" class="add-link btn btn-fab btn-fab-mini no-shadow no-color-bg" id="morewalkover"><i class="material-icons">add_circle</i></button>
                    </div>
                     <div class="no-walkover-wrap">
                        <div class="no-walkover-container animated fadeIn">
                            <div class="no-walkover"><div class="loadpic"><i class="fa fa-refresh fa-spin" style="font-size: 50px; color: rgba(0,0,0,0.44)"></i></div><img src="<?= base_url().'assets/img/no-walkover.png'?>" width="50px"></div>
                        </div>
                    </div>
                    <div class="modresult-walkover">
                        <div class="walkover hide" id="addwalkoverTemplate">
                            <div class="walkover-container">
                                <div class="walkoverteamname form-group">
                                    <div class="icon"><i class="fa fa-shield"></i></div>
                                    <select class="selectpicker show-tick selectwalkover custom-dropdown" id="selectWalkoverTeam" data-size="auto" data-width="fit" title="<?php echo lang('select_default');?>"></select>
                                </div>
                                <div class="walkover-team-remove withripple"><i class="material-icons">clear</i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>  