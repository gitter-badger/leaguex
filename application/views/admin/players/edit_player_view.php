<?php foreach ($player as $playerid):?>
<section id="main-wrapper"> 
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                 <h4 class="page-title"><?php echo lang('admin_eplayer_header_title');?> <?php echo $playerid->player_name;?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><a class="animsition-link" href="<?= base_url().'admin/players/players_list';?>"><?php echo lang('admin_plist_header_title');?></a></li>
                        <li><?php echo lang('admin_eplayer_header_title');?></li>
                    </ol>
                </div>
            </div>        
        </div> 
        <div class="row">
            <div class="col-md-12 animsition">                     
                <form action="<?php echo site_url("admin/players/edit_player/update_player");?>" method="post" role="form" name="updatePlayer" id="updatePlayer" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                    <div class="panel" style="min-height: 500px;">
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_eplayer_title_general');?></h2>                        
                        </header>                           
                        <div class="panel-body">                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('admin_eplayer_input_team');?>:</label>
                                <div class="col-sm-6">
                                    <select class="form-control show-tick show-menu-arrow selectpicker bullet" id="selectTeam" name="team">                                                
                                        <option value=""><?php echo lang('select_default');?></option>
                                            <?php foreach ($teams as $team):?>                                       
                                                <option value="<?php echo $team->team_id;?>"<?php if ($playerid->player_team_id == $team->team_id){echo "SELECTED";}?>><?php echo $team->team_name;?></option>
                                            <?php endforeach;?>                                     
                                    </select>
                                </div>    
                            </div>                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('admin_eplayer_input_position');?>:</label>
                                <div class="col-sm-6">
                                    <select class="form-control show-tick show-menu-arrow selectpicker bullet" id="selectPosition" name="position">                                                
                                        <?php foreach ($positions as $position):?>  
                                        <option value="<?php echo $position->player_position;?>"<?php if ($playerid->player_position == $position->player_position){echo "SELECTED";}?>><?php echo $position->player_position;?></option>
                                        <?php endforeach;?> 
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('admin_eplayer_input_age');?>:</label>
                                <div class="col-sm-6">
                                    <input type="text"class="form-control" id="inputAge" name="age" maxlength="2" value="<?php echo $playerid->player_age;?>"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('admin_eplayer_input_overall');?>:</label>
                                <div class="col-sm-6">
                                    <input type="text"class="form-control" id="inputOverall" name="overall" maxlength="2" value="<?php echo $playerid->player_overall;?>"> 
                                </div>
                            </div>                              
                            <div class="form-group">                                                                       
                                <div class="col-sm-6 col-sm-offset-3">                                    
                                    <input type="hidden" name="id" id="id" value="<?php echo $playerid->id;?>">
                                    <button type="submit" class="btn btn-success" id="btnUpdatePlayerForm"><?php echo lang('form_button_save_changes');?></button>
                                </div>
                            </div> 
                        </div>
                    </div>
                </form>                                                  
            </div>
        </div>
    </div>
</section>
<?php endforeach;?> 