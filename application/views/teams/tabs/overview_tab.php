<div class="tab-pane active" id="overview">
    <div class="row">
        <div class="col-1">
            <div class="col-lg-7">
        <?php if($userteam){ 
        foreach($userteam as $team): ?>
        <header class="team-heading">
            <div class="media clearfix">
                <div class="team-container">
                    <img src="<?= base_url().'assets/img/teams_logo/'.$team->team_logo;?>">
                </div>
                <div class="team-details">
                    <h1 class="team"><?php echo $team->team_name; ?></h1>
                    <div class="team-rate"><input type="hidden" class="form-control rating" id="inputLevel" name="teamlevel" data-filled="fa fa-star" data-empty="fa fa-star-o" data-readonly value="<?php echo $team->team_level; ?>"></div>
                    <div class="team-info">
                        <span class="label"><?php echo lang('uteam_title_panel_founded_squad');?>:</span><strong><?php echo date("Y", strtotime($team->team_registration_date));?></strong>
                    </div>
                    <div class="team-info">
                        <span class="label"><?php echo lang('uteam_title_panel_finance_squad');?>:</span><strong><?php echo number_format($team->manager_wallet, '0', '0', lang('mask_page'));?></strong>
                    </div>
                    <div class="team-info">
                        <span class="label"><?php echo lang('uteam_title_panel_players_squad');?>:</span><strong><?php echo $countplayers ?></strong>
                    </div> 
                </div>
            </div>
        </header>
        <?php endforeach; }else{ ?>
        <div class="team-heading">
            <div class="media clearfix">
                <div class="team-container">
                    <img src="<?= base_url().'assets/img/teams_logo/logo_default.png';?>">
                </div>
                <div class="team-details">
                    <h1 class="team">Undefined</h1>
                    <div class="team-rate"><input type="hidden" class="form-control rating" id="inputLevel" name="teamlevel" data-filled="fa fa-star" data-empty="fa fa-star-o" data-readonly value=""></div>
                    <div class="team-info">
                        <span class="label"><?php echo lang('uteam_title_panel_founded_squad');?>:</span><strong></strong>
                    </div>
                    <div class="team-info">
                        <span class="label"><?php echo lang('uteam_title_panel_finance_squad');?>:</span><strong></strong>
                    </div>
                    <div class="team-info">
                        <span class="label"><?php echo lang('uteam_title_panel_players_squad');?>:</span><strong></strong>
                    </div> 
                </div>
            </div>
            </div>    
            <?php } ?>
            </div>  
        </div>
    </div>
</div>