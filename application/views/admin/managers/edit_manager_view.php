<section id="main-wrapper"> 
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                <?php foreach ($manager as $managerid):?>
                    <h4 class="page-title"><?php echo lang('admin_emanager_header_title');?> <?php echo $managerid->user_name;?></h4>
                <?php endforeach;?>    
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><a class="animsition-link" href="<?= base_url().'admin/managers/managers_list';?>"><?php echo lang('admin_mlist_header_title');?></a></li>
                        <li><?php echo lang('admin_emanager_header_title');?></li>
                    </ol>
                </div>
            </div>        
        </div> 
        <div class="row">
            <div class="col-md-12 animsition">                     
                <div class="panel">
                     <form action="<?php echo site_url("admin/managers/edit_manager/update_manager");?>" method="post" role="form" name="updateManager" id="updateManager" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_emanager_title_general');?></h2>                        
                        </header>                           
                        <div class="panel-body pad-t-0">                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('admin_emanager_select_teamname');?>:</label>
                                <div class="col-sm-6">
                                    <select class="form-control show-tick selectpicker" id="selectTeamname" name="teamname" data-size="5">                                                
                                        <option value=""><?php echo lang('select_default');?></option>
                                        <?php foreach ($teams as $team):?>
                                        <?php foreach ($manager as $managerid):?>
                                            <option value="<?php if($team->team_id == null){echo $managerid->manager_team_id;}else{echo $team->team_id;}?>" <?php if ($team->team_id == $managerid->manager_team_id){echo "SELECTED";}?>><?php if($team->team_id == null){echo $managerid->team_name;}else{echo $team->team_name;}?></option>
                                        <?php endforeach;?> 
                                    <?php endforeach;?> 
                                    </select>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('admin_emanager_input_managerfinance');?>:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control format" id="inputManagerfinance" name="managerwallet" value="<?php echo $managerid->manager_wallet;?>" data-mask="<?php echo lang('mask_form');?>" data-mask-reverse="true" placeholder="<?php echo lang('admin_mlist_input_managerfinance');?>">
                                </div>
                            </div>
                            <div class="form-group">                                                                       
                                <div class="col-sm-6 col-sm-offset-3">                                    
                                    <input type="hidden" name="id" id="id" value="<?php echo $managerid->manager_id;?>">
                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $managerid->manager_user_id;?>">
                                    <button type="submit" class="btn btn-danger btn-raised" id="btnUpdateManagerForm"><span><?php echo lang('form_button_save_changes');?></span></button>
                                </div>
                            </div> 
                        </div>
                    </form>
                </div>    
            </div>
        </div>
    </div>
</section>
