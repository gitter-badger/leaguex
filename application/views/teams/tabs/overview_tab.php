<div class="tab-pane active" id="overview">
    <div class="row">
        <div class="col-1">
            <div class="col-lg-7">
                <?php
                foreach($userteam as $team):
               
                ?>
                <div class="team-box">
                    <div class="team-box-container">
                        <div class="team-box-logo">
                            <img src="<?= base_url().'assets/img/teams_logo/'.$team->team_logo;?>">
                        </div>
                        <div class="team-box-info">
                            <div class="team-box-name"><?php echo $team->team_name; ?></div>
                            <div class="team-box-rate"><input type="hidden" class="form-control rating" id="inputLevel" name="teamlevel" data-filled="fa fa-star" data-empty="fa fa-star-o" data-readonly value="<?php echo $team->team_level; ?>"></div>
                            <div class="team-box-stats-container">
                                <div class="team-box-stats">
                                    <div class="stats-count"><?php echo $countplayed->played; ?></div>
                                    <div class="stats-title">Played</div>
                                </div>
                                <div class="team-box-stats">
                                    <div class="stats-count"><?php echo $countplayed->win; ?></div>
                                    <div class="stats-title">Wins</div>
                                </div>
                                <div class="team-box-stats">
                                    <div class="stats-count"><?php echo $countplayed->loss; ?></div>
                                    <div class="stats-title">Losses</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>        
            </div>  
        </div>
    </div>
</div>