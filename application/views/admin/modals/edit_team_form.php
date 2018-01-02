<form action="<?php echo site_url("admin/teams/teams_list/edit_team");?>" method="post" role="form" name="editTeamForm" id="editTeamForm" autocomplete="off" novalidate="novalidate" class="fv-form fv-form-bootstrap" style="display:none;">
    <div class="modal-header">
        <h4 class="modal-title"><?php echo lang('admin_tlist_modal_edit_team_title');?></h4>
        <div class="modal-submit-btn">
            <button type="submit" class="btn btn-info" id="btnEditTeamForm"><span><?php echo lang('form_button_save');?></span></button>
            <button type="button" class="btn btn-info" data-dismiss="modal" data-target="#editTeam"><span><?php echo lang('form_button_close');?></span></button> 
            <input type="hidden" value="" id="editTeamId" name="teamid">
        </div>
    </div>
    <div class="modal-body-custom">
        <div class="form-group">
            <div class="team-logo-img">
                <div class="preview">
                    <div class="loading-container" data-id="" data-img="<?php echo site_url("assets/img/teams_logo/");?>" data-url="<?php echo site_url("admin/teams/teams_list/upload_handler");?>" id="image-preview">
                        <div class="loader loadimage"></div>
                    </div>
                </div>
                <div class="profile-avatar-wrap">
                    <img id="thumbImg" src="" alt="Logo">
                    <input type="hidden" id="img-ghost" name="img-ghost">
                    <div class="profile-avatar-btn" id="upload">
                        <div class="icon-wrap"><i class="material-icons">camera_alt</i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_tlist_input_teamname');?></label>
            <input type="text" class="form-control icon-clear pad-r-15" id="editInputTeamname" name="teamname"> 
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
        <div class="input-group">
            <span class="input-group-addon rating-remove"><i class="material-icons">clear</i></span>
            <div class="form-group">                                    
                <input type="hidden" class="form-control rating" id="editInputLevel" name="teamlevel" data-filled="fa fa-star" data-empty="fa fa-star-o">
            </div>
        </div>
    </div>
</form> 
