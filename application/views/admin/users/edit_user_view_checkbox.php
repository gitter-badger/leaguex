<?php foreach ($user as $userid):?>
<section id="main-wrapper"> 
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                 <h4 class="page-title"><?php echo lang('admin_euser_header_title');?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><a class="animsition-link" href="<?= base_url().'admin/users/users_list';?>"><?php echo lang('admin_ulist_header_title');?></a></li>
                        <li><?php echo lang('admin_euser_header_title');?></li>
                    </ol>
                </div>
            </div>        
        </div> 
        <div class="row">
            <div class="col-md-12 animsition">                     
                <form action="<?php echo site_url("admin/users/edit_user/update_user_data");?>" method="post" role="form" name="updateData" id="updateData" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                    <div class="content-box clearfix">
                        <header class="content-box-header mb-5 clearfix">
                            <h2><?php echo lang('admin_euser_title_account');?></h2>                        
                        </header>                           
                        <div class="content-box-form pad-b-5 clearfix">                                
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('esett_input_username');?>:</label>
                                <div class="col-sm-9">
                                    <input type="text"class="form-control" id="inputUsername" name="username" value="<?php echo $userid->user_name;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('esett_input_email');?>:</label>
                                <div class="col-sm-9">
                                    <input type="text"class="form-control" id="inputEmail" name="email" value="<?php echo $userid->user_email;?>">
                                </div>
                            </div>
                            <div class="form-group">    
                                <label class="col-sm-3 control-label"><?php echo lang('esett_pick_birthday');?>:</label>
                                <div class="col-sm-9">                                                                 
                                    <input type="text" class="form-control format" id="inputBirthday" name="birthday" data-mask="00/00/0000" value="<?php echo date("d/m/Y", strtotime($userid->user_birthday));?>">                                    
                                </div>
                            </div>    
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo lang('esett_select_permissions');?>:</label>
                                    <div class="col-sm-9">
                                        <select class="show-tick show-menu-arrow selectpicker bullet" name="permissions">                                                
                                            <option value="1" <?php if($userid->user_permissions == 1) {echo "selected=\"selected\"";}?>><?php echo lang('select_user_group_1');?></option> 
                                            <option value="2" <?php if($userid->user_permissions == 2) {echo "selected=\"selected\"";}?>><?php echo lang('select_user_group_2');?></option>   
                                            <option value="3" <?php if($userid->user_permissions == 3) {echo "selected=\"selected\"";}?>><?php echo lang('select_user_group_3');?></option>   
                                            <option value="4" <?php if($userid->user_permissions == 4) {echo "selected=\"selected\"";}?>><?php echo lang('select_user_group_4');?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">    
                                <label class="col-sm-3 control-label"><?php echo lang('admin_euser_checkbox_ban');?>:</label>
                                <div class="col-sm-9">
                                    <div class="checkbox-custom checkbox-inline pull-left">                                       
                                        <input type="checkbox" class="form-control" id="ban" name="ban" value="1" <?php if($userid->user_ban == 1){echo 'checked="checked"';}?>>
                                    <label for="ban"></label>
                                    </div>  
                                </div>
                            </div>    
                        </div>     
                         <header class="content-box-header mb-5 clearfix">
                            <h2><?php echo lang('admin_euser_title_info');?></h2>                        
                        </header>                      
                        <div class="content-box-form clearfix">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('esett_input_city');?>:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputCity" name="city" value="<?php echo $userid->city;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('esett_input_favorite_club');?>:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputfavoriteclub" name="favoriteclub" value="<?php echo $userid->favorite_club;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('esett_input_personal_message');?>:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="aboutme" rows="3" maxlength="150"><?php echo $userid->aboutme;?></textarea>
                                </div>
                            </div> 
                            <div class="form-group">                                                                       
                                <div class="col-sm-9 col-sm-offset-3">
                                    <div class="alert alert-icon alert-success alert-dismissible" role="alert" id="response-success">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">x</span>                        
                                        </button>
                                    <i class="icon fa fa-check pad-r-10"></i> <?php echo lang('form_update_success_message');?>
                                    </div> 
                                    <input type="hidden" name="id" id="id" value="<?php echo $userid->user_id;?>">
                                    <button type="submit" class="btn btn-success ladda-button" id="btnUpdateInfoForm" data-style="zoom-out"><?php echo lang('form_button_save_changes');?></button>
                                </div>
                            </div>  
                        </div>
                    </div>
                </form>
                <form action="<?php echo site_url("admin/users/edit_user/update_password");?>" method="post" role="form" name="updatePassword" id="updatePassword" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                    <div class="content-box clearfix">
                        <header class="content-box-header mb-5 clearfix">
                            <h2><?php echo lang('esett_title_change_password');?></h2>                        
                        </header>                          
                        <div class="content-box-form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('esett_input_new_password');?>:</label>
                                <div class="col-sm-9">
                                    <input type="password"class="form-control" id="inputPassword" name="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo lang('esett_input_confirm_password');?>:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="inputConfirmPassword" name="confirmPassword">
                                </div>
                            </div>                                    
                            <div class="form-group">                               
                                <div class="col-sm-9 col-sm-offset-3">
                                    <div class="alert alert-icon alert-success alert-dismissible" role="alert" id="response-success-psw">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">x</span>                        
                                        </button>
                                        <i class="icon fa fa-check pad-r-10"></i> <?php echo lang('form_update_success_message');?>
                                    </div> 
                                    <input type="hidden" name="idpsw" id="idpsw" value="<?php echo $userid->user_id;?>">
                                    <button type="submit" id="btnUpdateInfoForm" class="btn btn-success ladda-button" data-style="zoom-out"><?php echo lang('form_button_save_changes');?></button>
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
<script>
var ckusername = '<?php echo lang('form_validation_check_username');?>';      
var ckemail = '<?php echo lang('form_validation_check_email');?>'; 
var cklocal = '<?php echo lang('form_validation_message_language');?>';
var ckdate = '<?php echo lang('reg_input_birthday');?>';
</script>
