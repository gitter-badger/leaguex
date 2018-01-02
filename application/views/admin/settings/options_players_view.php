<section id="main-wrapper">
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                <h4 class="page-title"><?php echo lang('admin_oplayers_header_title');?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><?php echo lang('admin_oplayers_header_title');?></li>
                    </ol>
                </div>
            </div>     
        </div>
        <div class="row">
            <div class="col-md-12 animsition">
                <div class="panel">
                    <form action="<?php echo site_url("admin/settings/options_players/update_players_options");?>" method="post" role="form" name="updatePlayersOptions" id="updatePlayersOptions" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_oplayers_title_url_stats');?></h2>                          
                            <span class="panel-heading-desc"><?php echo lang('admin_oplayers_description_url_stats');?></span>                            
                        </header>
                        <div class="panel-body pad-t-0">
                            <div class="form-group">                                
                                <label class="col-md-2 control-label"><?php echo lang('admin_oplayers_input_url_stats');?></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control icon-clear pad-r-15" id="urlStats" name="urlStats" placeholder="<?php echo lang('admin_oplayers_input_placeholder_url_stats');?>" value="<?php echo $option->url_stats;?>">
                                    <span id="iconclear" class="fa fa-times-circle"></span>
                                </div>
                            </div>                           
                        </div>
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_oplayers_title_url_player_image');?></h2>
                            <span class="panel-heading-desc"><?php echo lang('admin_oplayers_description_url_player_image');?></span>                            
                        </header>
                        <div class="panel-body pad-t-0">
                            <div class="form-group">                                
                                <label class="col-md-2 control-label"><?php echo lang('admin_oplayers_input_url_player_image');?></label>
                                <div class="col-md-10">     
                                    <input type="text" class="form-control icon-clear pad-r-15" id="urlImage" name="urlImage" placeholder="<?php echo lang('admin_oplayers_input_placeholder_url_player_image');?>" value="<?php echo $option->url_image;?>">
                                    <span id="iconclear" class="fa fa-times-circle"></span>
                                </div>                               
                            </div>
                            <div class="form-group">                                                                       
                                <div class="col-md-10 col-md-offset-2">                                                             
                                    <button type="submit" class="btn btn-danger btn-raised" id="btnUpdateForm"><span><?php echo lang('form_button_save_changes');?></span></button>
                                </div>
                            </div>  
                        </div>
                    </form>
                </div>
                <div class="panel">
                     <form action="<?php echo site_url("admin/settings/options_players/update_levels_options");?>" method="post" role="form" name="updateLevelsOptions" id="updateLevelsOptions" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_oplayers_title_players_levels');?></h2>
                            <span class="panel-heading-desc"><?php echo lang('admin_oplayers_description_players_levels');?></span>                            
                        </header>
                         <div class="panel-body pad-t-0">
                            <div class="form-group">                                
                                <label class="col-md-2 control-label" style="margin-top: 3px"><?php echo lang('admin_oplayers_activate_levels');?></label>
                                <div class="col-md-10">
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" id="players-levels" name="playersLevels" value="1" <?php if ($option->players_levels == 1){echo "CHECKED";} ?>>
                                            <?php echo lang('admin_ogeneral_option_yes');?>
                                        </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" id="players-levels" name="playersLevels" value="0" <?php if ($option->players_levels == 0){echo "CHECKED";} ?>>
                                            <?php echo lang('admin_ogeneral_option_no');?>
                                        </label>
                                    </div>
                                </div>                               
                            </div>   
                            <div class="form-group mt-0">
                                <label class="col-md-2 control-label"><?php echo lang('admin_oplayers_input_levels');?></label>
                                <div class="col-md-10 no-pad">
                                    <?php $levmin = explode(",", $option->level_min);
                                          $levmax = explode(",", $option->level_max);
                                          $maxplayers = explode(",", $option->level_max_players);
                                    ?>
                                    <div class="col-xs-3">
                                        <input type="text" class="form-control" id="ova" name="levMin[]" placeholder="Min" value="<?php echo $levmin[0];?>" maxlength="2">
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="text" class="form-control" id="ova" name="levMax[]" placeholder="Max" value="<?php echo $levmax[0];?>" maxlength="2">
                                    </div>
                                    <div class="col-xs-4 input-group">
                                        <input type="text" class="form-control" id="ova" name="maxPlayers[]" placeholder="<?php echo lang('admin_oplayers_input_placeholder_max_players');?>" value="<?php echo $maxplayers[0];?>" maxlength="2">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-fab btn-fab-custom no-shadow no-color-bg addButton"><i class="material-icons">add</i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php $nextmin = array_slice($levmin, 1);
                                  $nextmax = array_slice($levmax, 1);
                                  $nextmaxplayers = array_slice($maxplayers, 1);                                           
                                  foreach ($nextmin as $index => $levmin){
                                  $levmax = $nextmax[$index];
                                  $maxplayers = $nextmaxplayers[$index];
                            ?>
                            <div class="form-group <?php if(!$nextmin){ echo 'hide'; } ?>">
                                <div class="col-md-10 col-md-offset-2 no-pad">
                                    <div class="col-xs-3">
                                        <input type="text" class="form-control" id="ova" name="levMin[]" placeholder="Min" value="<?php echo $levmin;?>" maxlength="2">
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="text" class="form-control" id="ova" name="levMax[]" placeholder="Max" value="<?php echo $levmax;?>" maxlength="2">
                                    </div>
                                    <div class="col-xs-4 input-group">
                                        <input type="text" class="form-control" id="ova" name="maxPlayers[]" placeholder="<?php echo lang('admin_oplayers_input_placeholder_max_players');?>" value="<?php echo $maxplayers;?>" maxlength="2">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-fab btn-fab-custom no-shadow no-color-bg removeButton"><i class="material-icons">remove</i></button>
                                        </span>    
                                    </div>
                                </div>
                            </div> 
                            <?php } ?>        
                            <div class="form-group hide" id="optionTemplate"> 
                                <div class="col-md-10 col-md-offset-2 no-pad">
                                    <div class="col-xs-3">
                                        <input type="text" class="form-control" id="ova" name="levMin[]" placeholder="Min" value="" maxlength="2">
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="text" class="form-control" id="ova" name="levMax[]" placeholder="Max" value="" maxlength="2">
                                    </div>
                                    <div class="col-xs-4 input-group">
                                        <input type="text" class="form-control" id="ova" name="maxPlayers[]" placeholder="<?php echo lang('admin_oplayers_input_placeholder_max_players');?>" value="" maxlength="2">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-fab btn-fab-custom no-shadow no-color-bg removeButton"><i class="material-icons">remove</i></button>
                                        </span>  
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">                                                                       
                                <div class="col-md-10 col-md-offset-2">                                                             
                                    <button type="submit" class="btn btn-danger btn-raised" id="btnUpdateForm"><span><?php echo lang('form_button_save_changes');?></span></button>
                                </div>
                            </div>  
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>    
</section>