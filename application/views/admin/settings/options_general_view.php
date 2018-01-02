<section id="main-wrapper">
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                <h4 class="page-title"><?php echo lang('admin_ogeneral_header_title');?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><?php echo lang('admin_ogeneral_header_title');?></li>
                    </ol>
                </div>
            </div>     
        </div>
        <div class="row">
            <div class="col-md-12 animsition">
                <div class="panel">
                     <form action="<?php echo site_url("admin/settings/options_general/update_general_options");?>" method="post" role="form" name="updateGeneralOptions" id="updateGeneralOptions" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_ogeneral_title_global_configuration');?></h2>                                                     
                        </header>                     
                        <div class="panel-body pad-t-0">
                            <div class="form-group">                                
                                <label class="col-md-2 control-label"><?php echo lang('admin_ogeneral_select_language');?></label>
                                <div class="col-md-10">
                                    <select class="form-control show-tick selectpicker" id="selectLanguage" name="language">                                   
                                        <option value="0" <?php if ($option->language == 0){echo "SELECTED";} ?>><?php echo lang('admin_ogeneral_language_ita');?></option>
                                        <option value="1" <?php if ($option->language == 1){echo "SELECTED";} ?>><?php echo lang('admin_ogeneral_language_eng');?></option>                                            
                                     
                                    </select>
                                </div>                      
                            </div>
                            <div class="form-group">                                
                                <label class="col-md-2 control-label"><?php echo lang('admin_ogeneral_input_site_name');?></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control icon-clear pad-r-15" id="sitename" name="sitename" placeholder="<?php echo lang('admin_ogeneral_input_placeholder_site_name');?>" value="<?php echo $option->site_name;?>">
                                    <span id="iconclear" class="fa fa-times-circle"></span>
                                </div>
                            </div>
                            <div class="form-group">                                
                                <label class="col-md-2 control-label"><?php echo lang('admin_ogeneral_input_site_title');?></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control icon-clear pad-r-15" id="sitetitle" name="sitetitle" placeholder="<?php echo lang('admin_ogeneral_input_placeholder_site_title');?>" value="<?php echo $option->site_title;?>">
                                </div>
                            </div>
                            <div class="form-group mt-10">                                
                                <label class="col-md-2 control-label"><?php echo lang('admin_ogeneral_page_transition');?></label>
                                <div class="col-md-10">
                                    <div class="radio radio-inline">
                                        <label>
                                        <input type="radio" id="transition" name="transition" value="0" <?php if ($option->transition == 0){echo "CHECKED";} ?>>
                                        <?php echo lang('admin_ogeneral_option_yes');?>
                                        </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <label>
                                        <input type="radio" id="transition" name="transition" value="1" <?php if ($option->transition == 1){echo "CHECKED";} ?>>
                                        <?php echo lang('admin_ogeneral_option_no');?>
                                        </label>
                                    </div>
                                    <span class="help-block show"><?php echo lang('admin_ogeneral_description_page_transition');?></span>
                                </div>                               
                            </div>
                            <div class="form-group">                                
                                <label class="col-md-2 control-label"><?php echo lang('admin_ogeneral_table_details');?></label>
                                <div class="col-md-10">
                                    <div class="radio radio-inline">
                                        <label>
                                        <input type="radio" id="details-visibile" name="details-visibile" value="0" <?php if ($option->table_details == 0){echo "CHECKED";} ?>>
                                        <?php echo lang('admin_ogeneral_option_yes');?>
                                        </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <label>
                                        <input type="radio" id="details-visibile" name="details-visibile" value="1" <?php if ($option->table_details == 1){echo "CHECKED";} ?>>
                                        <?php echo lang('admin_ogeneral_option_no');?>
                                        </label>
                                    </div>
                                    <p class="help-block show"><?php echo lang('admin_ogeneral_description_table_details');?></p>
                                </div>                               
                            </div>    
                            <div class="form-group mt-40">                                                                       
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
