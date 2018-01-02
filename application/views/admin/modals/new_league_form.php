<form action="<?php echo site_url("admin/competitions/leagues_list/add_league ");?>" method="post" role="form" name="addLeagueForm" id="addLeagueForm" autocomplete="off" novalidate="novalidate" class="fv-form fv-form-bootstrap" style="display:none;">
    <div class="modal-header">
        <h4 class="modal-title"><?php echo lang('admin_leagueslist_modal_add_league_title');?></h4>
        <div class="modal-submit-btn">
            <button type="submit" class="btn btn-info" id="btnAddLeagueForm"><span><?php echo lang('form_button_save');?></span></button>
            <button type="button" class="btn btn-info" data-dismiss="modal" data-target="#addLeague"><span><?php echo lang('form_button_close');?></span></button> 
        </div>
    </div>
    <div class="modal-body-custom">
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_leagueslist_select_leagueteams');?></label>
            <select class="show-tick selectpicker" id="selectTeams" data-width="100%" name="leagueteams[]" multiple data-none-selected-text="<?php echo lang('select_default');?>" data-select-all-text="<?php echo lang('select_all');?>" data-deselect-all-text="<?php echo lang('deselect_all');?>" data-size="4" data-actions-box="true" multiple data-selected-text-format="count > 3"></select>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo lang('admin_leagueslist_input_leaguename');?></label>
            <input type="text" class="form-control icon-clear pad-r-15" id="inputLeaguename" name="leaguename" required>
            <span id="iconclear" class="fa fa-times-circle"></span>
        </div>
    </div>
</form>
