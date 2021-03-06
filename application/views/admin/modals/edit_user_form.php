<form action="<?php echo site_url("admin/users/users_list/edit_user");?>" method="post" role="form" name="editUserForm" id="editUserForm" autocomplete="off" novalidate="novalidate" class="fv-form fv-form-bootstrap" style="display:none;">
    <div class="modal-header">
        <h4 class="modal-title"><?php echo lang('admin_ulist_modal_edit_user_title');?></h4>
        <div class="modal-submit-btn">
            <button type="submit" class="btn btn-info" id="btnEditUserForm"><span><?php echo lang('form_button_save');?></span></button>
            <button type="button" class="btn btn-info" data-dismiss="modal" data-target="#editUser"><span><?php echo lang('form_button_close');?></span></button> 
            <input type="hidden" value="" id="editUserId" name="userid">
        </div>
    </div>
    <div class="modal-body-custom">
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_ulist_modal_label_username');?></label>
            <input type="text" class="form-control icon-clear pad-r-15" id="editInputUsername" name="username"> 
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_ulist_modal_label_email');?></label>
            <input type="text" class="form-control icon-clear pad-r-15" id="editInputEmail" name="email"> 
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_ulist_modal_label_permission');?></label>
            <select class="show-tick selectpicker" id="editSelectPermission" name="permission" data-width="100%"></select> 
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_ulist_modal_label_password');?></label>
            <input type="password" class="form-control" id="editInputPassword" name="newpassword" autocomplete="new-password">
            <input type="hidden" class="form-control" id="hiddenPassword" name="password">
        </div> 
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_ulist_modal_label_birthday');?></label>
            <input type="text" class="form-control icon-clear pad-r-15 format" id="editInputBirthday" name="birthday" autocomplete="off">
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
       
    </div>    
</form>       