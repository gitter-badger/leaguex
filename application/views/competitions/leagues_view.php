<section id="main-wrapper">
    <div class="container-fluid animsition pad-dyn">
        <div class="row">
            <div class="col-1">
                <div class="col-lg-7">
                    <div class="filter-custom">
                        <div class="filter-wrap">
                            <select class="show-tick selectpicker m-r-a" data-width="fit" id="selectLeagues" name="leaguename" <?php if(!is_array($getlastleague)){echo 'disabled';} ?> data-none-selected-text="<?php echo lang('league_select_all_fixtures');?>"></select>
                            <select class="show-tick selectpicker" data-width="fit" data-dropdown-Align-Right="auto" id="selectTeams" name="teamname"  <?php if(!is_array($getlastleague)){echo 'disabled';} ?>>
                                <option value=""><?php echo lang('league_select_all_teams');?></option>
                                <?php
                                foreach($getlastteams as $showteam):
                                echo '<option value="'.$showteam->team_id.'">'.$showteam->team_name.'</option>';
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>    
                    <div id="fixture-table">
                        <?php if(!is_array($getlastleague)){ ?>
                        <div class="no-fixtures-wrap">
                            <div class="no-fixtures-container">
                                <div class="no-fixtures">
                                    <img src="<?= base_url().'assets/img/no-leagues.png'?>" width="100" height="100">
                                    <div class="no-fixtures-text"><?php echo lang('no_fixtures_text')?></div>
                                </div>
                            </div>
                        </div>
                        <?php } ?> 
                        <div id="loading" class="loading-block loadpage"></div>
                        <ul class="matchlist list-unstyled">
                            <?php
                            $matchdayNull = null; 
                            $div = '';
                            if(is_array($getlastleague)){
                            foreach($getlastleague as $showmatches):
                                $matchdayName = $showmatches->matchday_name; 
                                if($matchdayName != $matchdayNull){ 
                                    echo $div;
                                    echo '<div class="panel">
                                          <div class="panel-body">
                                          <li class="matchlist-heading">
                                          <div class="matchlist-competition-logo"><img src="'.base_url().'assets/img/competitions_logo/'.$showmatches->competition_logo.'"></div>
                                          <div class="matchlist-competition-name">'.$showmatches->competition_name.'&nbsp-&nbsp</div>
                                          <div class="matchlist-day-title">'.lang("league_matchday_title").'&nbsp'.$matchdayName.'</div>    
                                          </li>';
                                }
                                $matchdayNull = $matchdayName;                               
                            ?>
                            <li>
                                <a href="<?= base_url().'competitions/match/matchid/'.$showmatches->match_id;?>" class="animsition-link fixture-wrap">
                                    <span class="fixture-match">
                                        <span class="fixture-teams">
                                            <span class="teams"><span class="team-name"><span class="full-text"><?php echo $showmatches->team1;?></span><span class="compare-text"><?php echo compare_text($showmatches->team1, $showmatches->team2);?></span></span><span class="fixture-team-logo"><img src="<?= base_url().'assets/img/teams_logo/'.$showmatches->logo1;?>"></span></span><span class="match-score"><?php foreach($getmanagers as $manager):if(($manager->manager_team_id == $showmatches->teamid1 && $showmatches->match_status == 0)||($manager->manager_team_id == $showmatches->teamid2 && $showmatches->match_status == 0)){echo '<span class="material-icons match-game">games</span>';}else{echo $showmatches->score1. ' - ' .$showmatches->score2;}endforeach;?></span><span class="teams"><span class="team-name"><span class="full-text"><?php echo $showmatches->team2;?></span><span class="compare-text"><?php echo substr($showmatches->team2, 0,3);?></span></span><span class="fixture-team-logo"><img src="<?= base_url().'assets/img/teams_logo/'.$showmatches->logo2;?>"></span></span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <?php $div = '</div></div>'; endforeach; } ?>
                         </ul>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</section>