<section id="main-wrapper">
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                <h4 class="page-title"><?php echo lang('admin_ocompetitions_header_title');?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><?php echo lang('admin_ocompetitions_header_title');?></li>
                    </ol>
                </div>
            </div>     
        </div>
        <div class="row">
            <div class="col-md-12 animsition">
                <div class="panel">
                    <form action="<?php echo site_url("admin/settings/options_competitions/update_events_options");?>" method="post" role="form" name="updateEventsOptions" id="updateEventsOptions" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_ocompetitions_title_events');?></h2>
                            <span class="panel-heading-desc"><?php echo lang('admin_ocompetitions_description_events');?></span>
                        </header>
                        <div class="panel-body pad-t-0">
                            <?php $count = 0; $count++; foreach ($getevents as $events):?>
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo lang('admin_ocompetitions_input_events');?></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control icon-clear pad-r-15" id="eventName" name="eventName[]" placeholder="<?php echo lang('admin_ocompetitions_input_placeholder_event_name');?>" value="<?php echo $events->event_desc;?>">
                                    <span id="iconclear" class="fa fa-times-circle"></span>
                                </div>
                                <div class="col-md-6 input-group">
                                    <input type="text" id="inputFile" name="eventImage[]" class="form-control" data-url="<?php echo site_url("admin/settings/options_competitions/upload_handler");?>" placeholder="<?php echo lang('admin_ocompetitions_input_placeholder_event_image');?>" readonly value="<?php echo $events->event_icon;?>">
                                    <span class="input-group-btn">
                                        <button type="button" id="uploadFile_<?php echo $count ?>" onMouseOver="fileUpload(<?php echo $count ?>);" class="btn btn-fab btn-fab-custom no-shadow no-color-bg uploadFile"><i class="material-icons">image</i></button>
                                    </span>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-fab-custom no-shadow no-color-bg <?php if($count > 1){echo 'removeButton';}else{echo 'addButton';}?>"><i class="material-icons"><?php if($count++ > 1){echo 'remove';}else{echo 'add';}?></i></button>
                                    </span>
                                </div>
                            </div>
                            <?php endforeach;?> 
                            <div class="form-group hide" id="optionTemplate">
                                <label class="col-md-2 control-label"><?php echo lang('admin_ocompetitions_input_events');?></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control pad-r-15" id="eventName" placeholder="<?php echo lang('admin_ocompetitions_input_placeholder_event_name');?>" value="">
                                    <span id="iconclear" class="fa fa-times-circle"></span>
                                </div>
                                <div class="col-md-6 input-group">
                                    <input type="text" id="inputFile" class="form-control" data-url="<?php echo site_url("admin/settings/options_competitions/upload_handler");?>" readonly placeholder="<?php echo lang('admin_ocompetitions_input_placeholder_event_image');?>" value="">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-fab-custom no-shadow no-color-bg uploadFile"><i class="material-icons">image</i></button>
                                    </span>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-fab-custom no-shadow no-color-bg removeButton"><i class="material-icons">remove</i></button>
                                    </span> 
                                </div>
                            </div>
                             <div class="form-group">                                                                       
                                <div class="col-md-10 col-md-offset-2">                                                             
                                    <button type="submit" class="btn btn-danger btn-raised" id="btnUpdateForm"><span><?php echo lang('form_button_save_changes');?></span></button>
                                </div>
                            </div>  
                        </div> 
                    </form> 
                </div>
            </div> 
        </div>
    </div>    
</section>
