<form action="<?php echo site_url("admin/teams/teams_list/add_team");?>" method="post" role="form" name="addTeamForm" id="addTeamForm" autocomplete="off" novalidate="novalidate" class="fv-form fv-form-bootstrap" style="display:none;">
    <div class="modal-header">
        <h4 class="modal-title"><?php echo lang('admin_tlist_modal_add_team_title');?></h4>
        <div class="modal-submit-btn">
            <button type="submit" class="btn btn-info" id="btnAddTeamForm"><span><?php echo lang('form_button_save');?></span></button>
            <button type="button" class="btn btn-info" data-dismiss="modal" data-target="#addTeam"><?php echo lang('form_button_close');?></button> 
        </div>
    </div>
    <div class="modal-body-custom">
        <div class="input-group">
            <span class="input-group-addon"><i class="material-icons">security</i></span>
            <div class="form-group">
                <input type="text" class="form-control" id="inputTeamname" name="teamname" placeholder="<?php echo lang('admin_tlist_input_teamname');?>">                                                        
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-addon rating-remove"><i class="material-icons">clear</i></span>
            <div class="form-group">                                    
                <input type="hidden" class="form-control rating" id="inputLevel" name="teamlevel" data-filled="fa fa-star" data-empty="fa fa-star-o">
            </div>
        </div>
    </div>
</form> 
