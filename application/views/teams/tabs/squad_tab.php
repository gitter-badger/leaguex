<?php if(!$userplayer){echo '<div class="col-lg-12 advice-text text-center"><h4>'.lang('uteam_text_card_noplayers_squad');'</h4></div>';}else{?> 
<div class="tab-pane fade in active" id="tab-myteam">
    <?php foreach($userplayer as $player):

        // Overall range levels
        $levmin = explode(",", $player->level_min);
        $levmax = explode(",", $player->level_max);
        $maxplayers = explode(",", $player->level_max_players);
        $array_range = array();
        foreach ($levmin as $index => $player->level_min){
        $levelmax = $levmax[$index];
         if(($player->player_overall >= $player->level_min)&&($player->player_overall <= $levelmax)){
            $array_range[] = $player->level_min.'/'.$levelmax;
        }
    }
    $overall_range = implode(",", $array_range); 

    // Overall values text color
    $ova1 = (($player->player_overall >= 40)&&($player->player_overall <= 49));
    $ova2 = (($player->player_overall >= 50)&&($player->player_overall <= 59));
    $ova3 = (($player->player_overall >= 60)&&($player->player_overall <= 69));
    $ova4 = (($player->player_overall >= 70)&&($player->player_overall <= 79));
    $ova5 = (($player->player_overall >= 80)&&($player->player_overall <= 89));
    $ova6 = (($player->player_overall >= 90)&&($player->player_overall <= 99));
    ?>        
    <div class="col-md-4 col-sm-6 col-xs-12 custom-col">
        <div class="panel player-widget">
            <div class="player-widget-header panel-info">
                <div class="player-widget-container">
                <img src="<?php echo $player->url_image.$player->player_id.'.png';?>" onerror="imgError(this);">
                <span class="player-widget-info">
                    <span class="player-overall <?php if($player->player_overall == $ova1){echo "text-grey";}elseif ($player->player_overall == $ova2){echo "text-blue";}elseif ($player->player_overall == $ova3){echo "text-green";}elseif ($player->player_overall == $ova4){echo "text-purple";}elseif ($player->player_overall == $ova5){echo "text-orange";}elseif ($player->player_overall == $ova6){echo "text-red";} ?>"><?php echo $player->player_overall;?></span>
                    <h4 class="player-name"><?php echo $player->player_name; ?></h4>
                    <span class="player-position"><?php echo $player->player_position; ?></span>
                </span>
                </div>
            </div>
            <ul class="player-widget-stats list-unstyled">
                <li>
                    <dl>
                        <dt><?php echo lang('uteam_title_card_age_squad');?></dt>
                        <dd><?php echo $player->player_age; ?></dd>
                    </dl>
                </li>
                <?php if($player->players_levels == 1){ ?>
                <li>
                     <dl>
                        <dt><?php echo lang('uteam_title_card_level_squad');?></dt>
                        <dd><?php echo $overall_range;?></dd>
                    </dl>
                </li>
                <?php } ?>
                <li>
                     <dl>
                        <dt>Valore</dt>
                        <dd>70.000</dd>
                    </dl>
                </li>
                <li>
                     <dl>
                        <dt>Gol</dt>
                        <dd>8</dd>
                    </dl>
                </li>
            </ul>
            <div class="panel-footer">
                <span class="player-widget-link"><a href="<?php echo $player->url_stats.$player->player_id; ?>" target="_new"><i class="fa fa-bar-chart"></i></a></span>
                <span class="player-widget-link"><a href="<?php echo $player->player_link_tm; ?>" target="_new"><i class="fa fa-money"></i></a></span>
            </div> 
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php } ?>
