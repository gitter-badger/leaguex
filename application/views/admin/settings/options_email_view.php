<section id="main-wrapper">
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                <h4 class="page-title"><?php echo lang('admin_omail_header_title');?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><?php echo lang('admin_omail_header_title');?></li>
                    </ol>
                </div>
            </div>     
        </div>
        <div class="row">
            <div class="col-md-12 animsition">
                <div class="panel">
                    <form action="<?php echo site_url("admin/settings/options_email/update_email_options");?>" method="post" role="form" name="updateEmailOptions" id="updateEmailOptions" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_omail_title_smtp_options');?></h2>                          
                            <span class="panel-heading-desc"><?php echo lang('admin_omail_description_smtp_options');?></span>                            
                        </header>
                        <div class="panel-body pad-t-0">
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_omail_input_email');?>:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="<?php echo lang('admin_omail_input_placeholder_email');?>" value="<?php echo $option->smtp_email;?>">
                                    <p class="help-block show"><?php echo lang('admin_omail_subtitle_input_email');?>.</p>
                                </div>
                            </div>
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_omail_input_name');?>:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo lang('admin_omail_input_placeholder_name');?>" value="<?php echo $option->smtp_name;?>">
                                    <p class="help-block show"><?php echo lang('admin_omail_subtitle_input_name');?>.</p>
                                </div>
                            </div>
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_omail_input_host');?>:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="host" name="host" placeholder="<?php echo lang('admin_omail_input_placeholder_host');?>" value="<?php echo $option->smtp_host;?>">
                                    <p class="help-block show"><?php echo lang('admin_omail_subtitle_input_host');?>.</p>
                                </div> 
                            </div>
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_omail_input_port');?>:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="port" name="port" placeholder="<?php echo lang('admin_omail_input_placeholder_port');?>" value="<?php echo $option->smtp_port;?>">
                                    <p class="help-block show"><?php echo lang('admin_omail_subtitle_input_port');?>.</p>
                                </div>
                            </div>                            
                            <div class="form-group mt-25"> 
                                 <div class="col-md-12 col-sm-offset-3 mt-5 mb-25">
                                     <p class="small"><?php echo lang('admin_omail_subtitle_authentication');?></p>
                                </div>
                                <label class="col-sm-3 control-label"><?php echo lang('admin_omail_input_username');?>:</label>                                                               
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="<?php echo lang('admin_omail_input_placeholder_username');?>" value="<?php echo $option->smtp_user;?>">
                                    <p class="help-block show"><?php echo lang('admin_omail_subtitle_input_username');?>.</p>
                                </div>
                            </div>
                             <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_omail_input_password');?>:</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $option->smtp_pass;?>" autocomplete="new-password">
                                    <p class="help-block show"><?php echo lang('admin_omail_subtitle_input_password');?>.</p>
                                </div>
                            </div>
                            <div class="form-group mt-40">                                                                       
                                <div class="col-sm-6 col-sm-offset-3">                                                             
                                    <button type="submit" class="btn btn-danger btn-raised" id="btnUpdateForm"><span><?php echo lang('form_button_save_changes');?></span></button>
                                </div>
                            </div>  
                        </div>             
                    </form>
                </div>
                <div class="panel">
                    <form action="<?php echo site_url("admin/settings/options_email/test_email_options");?>" method="post" role="form" name="testEmailOptions" id="testEmailOptions" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_omail_title_test_smtp_options');?></h2>                          
                            <span class="panel-heading-desc"><?php echo lang('admin_omail_description_test_smtp_options');?></span>                            
                        </header>
                        <div class="panel-body pad-t-0">
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_omail_input_test_smtp');?>:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="testemail" name="testemail" value="">
                                </div>                               
                            </div>                    
                            <div class="form-group">                                                                       
                                <div class="col-sm-6 col-sm-offset-3">                                                             
                                    <button type="submit" class="btn btn-danger btn-raised" id="btnUpdateForm"><span><?php echo lang('admin_omail_form_button_send_test');?></span></button>
                                </div>
                            </div>  
                        </div>             
                    </form>
                </div>
            </div> 
        </div>
    </div>    
</section>