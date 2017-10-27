<form action="<?php echo site_url("users/edit_settings/update_account");?>" method="post" role="form" name="editUserAccountForm" id="editUserAccountForm" novalidate autocomplete="off" class="fv-form fv-form-bootstrap" style="display:none;">
    <div class="modal-header">
        <h4 class="modal-title"><?php echo lang('esett_modal_edit_account_title');?></h4>
        <div class="modal-submit-btn">
            <button type="submit" class="btn btn-info" id="btnEditUserAccountForm"><span><?php echo lang('form_button_save');?></span></button>
            <button type="button" class="btn btn-info" data-dismiss="modal" data-target="#editAccount"><span><?php echo lang('form_button_close');?></span></button> 
            <input type="hidden" value="" id="editUserId" name="userid">
        </div>
    </div>
    <div class="modal-body-custom">
        <div class="form-group label-floating">
            <label class="control-label"><?php echo lang('esett_modal_label_email');?></label>
            <input type="text" class="form-control" id="editInputEmail" name="email"> 
        </div>
        <div class="form-group label-floating">
            <label class="control-label"><?php echo lang('esett_modal_label_birthday');?></label>
            <input type="text" class="form-control format" id="editInputBirthday" name="birthday" autocomplete="off" placeholder="<?php echo lang('esett_pick_birthday');?>">
        </div>
        <div class="form-group label-floating">
            <label class="control-label"><?php echo lang('esett_modal_label_city');?></label>
            <input type="text" class="form-control" id="editInputCity" name="city" autocomplete="off" maxlength="50">
        </div>
        <div class="form-group label-floating">
            <label class="control-label"><?php echo lang('esett_modal_label_change_password');?></label>
            <input type="password" class="form-control" id="editInputPassword" name="newpassword" autocomplete="new-password">
            <input type="hidden" class="form-control" id="hiddenPassword" name="password" autocomplete="new-password">
        </div>
        <div class="form-group label-floating">
            <label class="control-label"><?php echo lang('esett_modal_label_confirm_password');?></label>
            <input type="password" class="form-control" id="editInputConfirmPassword" name="confirmpassword" autocomplete="new-password">
        </div> 
    </div>    
</form>