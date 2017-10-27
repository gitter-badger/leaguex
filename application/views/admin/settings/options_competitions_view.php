<section id="main-wrapper">
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                <h4 class="page-title"><?php echo lang('admin_ocompetitions_header_title');?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><?php echo lang('admin_ocompetitions_header_title');?></li>
                    </ol>
                </div>
            </div>     
        </div>
        <div class="row">
            <div class="col-md-12 animsition">
                <div class="panel">
                     <form action="<?php echo site_url("admin/settings/options_competitions/update_competitions_options");?>" method="post" role="form" name="updatecompetitionsOptions" id="updatecompetitionsOptions" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_ocompetitions_title_players_levels');?></h2>
                            <span class="panel-heading-desc"><?php echo lang('admin_ocompetitions_description_players_levels');?></span>                            
                        </header>
                         <div class="panel-body pad-t-0">
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_ocompetitions_activate_levels');?>:</label>
                                <div class="col-sm-6">     
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
                            <div class="form-group">
                                 <label class="col-sm-3 control-label"><?php echo lang('admin_ocompetitions_input_levels');?>:</label>
                                 <div class="col-sm-8">
                                    <?php $levmin = explode(",", $option->level_min);
                                          $levmax = explode(",", $option->level_max);
                                          $maxplayers = explode(",", $option->level_max_players);
                                    ?>
                                    <div class="form-group">
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="ova" name="levMin[]" placeholder="Min" value="<?php echo $levmin[0];?>" maxlength="2">
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="ova" name="levMax[]" placeholder="Max" value="<?php echo $levmax[0];?>" maxlength="2">
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="ova" name="maxPlayers[]" placeholder="<?php echo lang('admin_ocompetitions_input_placeholder_max_players');?>" value="<?php echo $maxplayers[0];?>" maxlength="2">
                                        </div>
                                        <div class="col-xs-1">
                                            <button type="button" class="btn btn-fab btn-fab-custom no-shadow no-color-bg addButton"><i class="material-icons">add</i></button>
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
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="ova" name="levMin[]" placeholder="Min" value="<?php echo $levmin;?>" maxlength="2">
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="ova" name="levMax[]" placeholder="Max" value="<?php echo $levmax;?>" maxlength="2">
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="ova" name="maxPlayers[]" placeholder="<?php echo lang('admin_ocompetitions_input_placeholder_max_players');?>" value="<?php echo $maxplayers;?>" maxlength="2">
                                        </div>
                                        <div class="col-xs-1">
                                            <button type="button" class="btn btn-fab btn-fab-custom no-shadow no-color-bg removeButton"><i class="material-icons">remove</i></button>
                                        </div>                                      
                                    </div> 
                                    <?php } ?>        
                                    <div class="form-group hide" id="optionTemplate">                                        
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="ova" name="levMin[]" placeholder="Min" value="" maxlength="2">
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="ova" name="levMax[]" placeholder="Max" value="" maxlength="2">
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="ova" name="maxPlayers[]" placeholder="<?php echo lang('admin_ocompetitions_input_placeholder_max_players');?>" value="" maxlength="2">
                                        </div>
                                        <div class="col-xs-1">
                                            <button type="button" class="btn btn-fab btn-fab-custom no-shadow no-color-bg removeButton removeButton"><i class="material-icons">remove</i></button>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">                                                                       
                                <div class="col-sm-6 col-sm-offset-3">                                                             
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
