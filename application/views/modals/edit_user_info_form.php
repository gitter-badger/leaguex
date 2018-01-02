<form action="<?php echo site_url("users/edit_settings/update_info");?>" method="post" role="form" name="editUserInfoForm" id="editUserInfoForm" autocomplete="off" class="fv-form fv-form-bootstrap" style="display:none;">
    <div class="modal-header">
        <h4 class="modal-title"><?php echo lang('esett_modal_edit_info_title');?></h4>
        <div class="modal-submit-btn">
            <button type="submit" class="btn btn-info" id="btnEditUserInfoForm"><span><?php echo lang('form_button_save');?></span></button>
            <button type="button" class="btn btn-info" data-dismiss="modal" data-target="#editInfo"><span><?php echo lang('form_button_close');?></span></button> 
            <input type="hidden" value="" id="editUserId" name="userid">
        </div>
    </div>
    <div class="modal-body-custom">
        <div class="form-group">
            <label class="control-label"><?php echo lang('esett_modal_label_skype');?></label>
            <input type="text" class="form-control icon-clear pad-r-15" id="editInputSkype" name="skype" maxlength="50">
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo lang('esett_modal_label_xbox');?></label>
            <input type="text" class="form-control icon-clear pad-r-15" id="editInputXbox" name="xbox" maxlength="50"> 
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo lang('esett_modal_label_psn');?></label>
            <input type="text" class="form-control icon-clear pad-r-15" id="editInputPsn" name="psn" maxlength="50"> 
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo lang('esett_modal_label_favorite_club');?></label>
            <input type="text" class="form-control icon-clear pad-r-15" id="editInputfavoriteclub" name="favoriteclub" maxlength="50"> 
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo lang('esett_modal_label_about_me');?></label>
            <textarea type="textarea" class="form-control" id="editInputAboutMe" name="aboutme"></textarea> 
        </div>
    </div>    
</form>

