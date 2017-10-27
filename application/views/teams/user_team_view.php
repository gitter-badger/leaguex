<section id="main-wrapper">
    <div class="container-fluid animsition pad-dyn">        
        <div class="row">
            <div class="col-md-12">
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
        <div class="row">
        <div class="col-md-12">    
        <nav class="team-panel-tabs">
            <ul class="team-tabs col-md-12">
                <li class="active">
                    <a href="#tab-myteam" data-toggle="tab"><?php echo lang('uteam_tab_squad');?></a>
                </li>
                <li>
                    <a href="#tab-teamstats" data-toggle="tab">Stats</a>
                </li>
                 <li>
                    <a href="#tab-teamstats" data-toggle="tab">Auctions</a>
                </li>
                <li>
                    <a href="#tab-teamstats" data-toggle="tab">Settings</a>
                </li>
                <li>
                    <a href="#tab-teamstats" data-toggle="tab">More</a>
                </li>
            </ul>
        </nav>
        </div>
        </div>
        <div class="row">           
            <div class="tab-content" style="min-height: 470px;">
             <?php $this->load->view('teams/tabs/squad_tab');?>     
            </div>
           
        </div>
    </div>
</section>