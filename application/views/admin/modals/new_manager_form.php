<form action="<?php echo site_url("admin/managers/managers_list/add_manager");?>" method="post" role="form" name="addManagerForm" id="addManagerForm" autocomplete="off" novalidate="novalidate" class="fv-form fv-form-bootstrap" style="display:none">
    <div class="modal-header">
        <h4 class="modal-title"><?php echo lang('admin_mlist_modal_add_manager_title');?></h4>
        <div class="modal-submit-btn">
            <button type="submit" class="btn btn-info" id="btnAddManagerForm"><span><?php echo lang('form_button_save');?></span></button>
            <button type="button" class="btn btn-info" data-dismiss="modal" data-target="#addManager"><?php echo lang('form_button_close');?></button> 
        </div>
    </div>
    <div class="modal-body-custom">
        <div class="input-group">
            <span class="input-group-addon"><i class="material-icons">security</i></span>
            <div class="form-group">                                    
                <select class="show-tick selectpicker" id="selectTeamname" name="teamname" data-size="auto" data-live-search="true" data-live-search-placeholder="<?php echo lang('table_search_placeholder');?>" title="<?php echo lang('admin_mlist_select_teamname');?>"></select>       
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="material-icons">face</i></span>
            <div class="form-group">
                <select class="show-tick selectpicker" id="selectUsername" name="username" data-size="auto" data-live-search="true" data-live-search-placeholder="<?php echo lang('table_search_placeholder');?>" title="<?php echo lang('admin_mlist_select_username');?>"></select>                                                            
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="material-icons">attach_money</i></span>
            <div class="form-group">
                <input type="text" class="form-control format" id="inputManagerfinance" name="managerwallet" data-mask="<?php echo lang('mask_form');?>" data-mask-reverse="true" placeholder="<?php echo lang('admin_mlist_input_managerfinance');?>">                                                        
            </div>
        </div> 
    </div>
</form>    

