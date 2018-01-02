<form action="<?php echo site_url("admin/users/users_list/add_user");?>" method="post" role="form" name="registerForm" id="registerForm" autocomplete="off" novalidate="novalidate" class="fv-form fv-form-bootstrap" style="display:none;">
    <div class="modal-header">
        <h4 class="modal-title"><?php echo lang('admin_ulist_modal_add_user_title');?></h4>
        <div class="modal-submit-btn">
            <button type="submit" class="btn btn-info" id="btnRegisterForm"><span><?php echo lang('form_button_save');?></span></button>
            <button type="button" class="btn btn-info" data-dismiss="modal" data-target="#addUser"><?php echo lang('form_button_close');?></button> 
        </div>
    </div>
    <div class="modal-body-custom">
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_ulist_modal_label_username');?></label>
            <input type="text" class="form-control icon-clear pad-r-15" id="inputUsername" name="username"> 
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_ulist_modal_label_email');?></label>
            <input type="text" class="form-control icon-clear pad-r-15" id="inputEmail" name="email"> 
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_ulist_modal_label_password');?></label>
            <input type="password" class="form-control icon-clear pad-r-15" id="inputPassword" name="password" autocomplete="new-password">
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div> 
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_ulist_modal_label_birthday');?></label>
            <input type="text" class="form-control icon-clear pad-r-15 format" id="inputBirthday" name="birthday" autocomplete="off">
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
        
    </div>    
</form>       