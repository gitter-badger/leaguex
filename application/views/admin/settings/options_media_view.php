<section id="main-wrapper">
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                <h4 class="page-title"><?php echo lang('admin_omedia_header_title');?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><?php echo lang('admin_omedia_header_title');?></li>
                    </ol>
                </div>
            </div>     
        </div>
        <div class="row">
            <div class="col-md-12 animsition">
                <div class="panel">
                    <form action="<?php echo site_url("admin/settings/options_media/update_media_options");?>" method="post" role="form" name="updateMediaOptions" id="updateMediaOptions" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_omedia_title_avatar_image');?></h2>                          
                            <span class="panel-heading-desc"><?php echo lang('admin_omedia_description_avatar_image');?></span>                            
                        </header>
                        <div class="panel-body pad-t-0">
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_omedia_input_maxsize');?></label>
                                <div class="col-sm-8">
                                    <div class="form-group" style="margin: 0;">                                        
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="avatarMaxWidth" name="avatarMaxWidth" placeholder="<?php echo lang('admin_omedia_input_placeholder_width');?>" value="<?php echo $option->avatar_size_maxwidth;?>" maxlength="3">
                                        </div>                                        
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="avatarMaxHeight" name="avatarMaxHeight" placeholder="<?php echo lang('admin_omedia_input_placeholder_height');?>" value="<?php echo $option->avatar_size_maxheight;?>" maxlength="3">
                                        </div>                                        
                                    </div>
                                    <input type="hidden" name="avatarSizeMax" value="0"/>
                                </div>
                            </div>
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_omedia_input_minsize');?></label>
                                <div class="col-sm-8">
                                    <div class="form-group" style="margin: 0;">                                        
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="avatarMinWidth" name="avatarMinWidth" placeholder="<?php echo lang('admin_omedia_input_placeholder_width');?>" value="<?php echo $option->avatar_size_minwidth;?>" maxlength="3">
                                        </div>                                        
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="avatarMinHeight" name="avatarMinHeight" placeholder="<?php echo lang('admin_omedia_input_placeholder_height');?>" value="<?php echo $option->avatar_size_minheight;?>" maxlength="3">
                                        </div>                                        
                                    </div>
                                    <input type="hidden" name="avatarSizeMin" value="0"/>
                                    <p class="help-block show"><?php echo lang('admin_omedia_subtitle_avatar_image');?>.</p>
                                </div>
                            </div>
                        </div>
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_omedia_title_teamlogo_image');?></h2>
                            <span class="panel-heading-desc"><?php echo lang('admin_omedia_description_teamlogo_image');?></span>                            
                        </header>
                        <div class="panel-body pad-t-0">
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_omedia_input_maxsize');?></label>
                                <div class="col-sm-8">
                                    <div class="form-group" style="margin: 0;">                                        
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="logoMaxWidth" name="logoMaxWidth" placeholder="<?php echo lang('admin_omedia_input_placeholder_width');?>" value="<?php echo $option->logo_size_maxwidth;?>" maxlength="3">
                                        </div>                                        
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="logoMaxHeight" name="logoMaxHeight" placeholder="<?php echo lang('admin_omedia_input_placeholder_height');?>" value="<?php echo $option->logo_size_maxheight;?>" maxlength="3">
                                        </div>                                       
                                    </div>
                                    <input type="hidden" name="logoSizeMax" value="0"/>
                                </div>                               
                            </div>
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_omedia_input_minsize');?></label>
                                <div class="col-sm-8">
                                    <div class="form-group" style="margin: 0;">                                        
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="logoMinWidth" name="logoMinWidth" placeholder="<?php echo lang('admin_omedia_input_placeholder_width');?>" value="<?php echo $option->logo_size_minwidth;?>" maxlength="3">
                                        </div>                                        
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control" id="logoMinHeight" name="logoMinHeight" placeholder="<?php echo lang('admin_omedia_input_placeholder_height');?>" value="<?php echo $option->logo_size_minheight;?>" maxlength="3">
                                        </div>                                        
                                    </div>
                                    <input type="hidden" name="logoSizeMin" value="0"/>
                                    <p class="help-block show"><?php echo lang('admin_omedia_subtitle_teamlogo_image');?>.</p>
                                </div>
                            </div>
                            <div class="form-group mt-40">                                                                       
                                <div class="col-sm-6 col-sm-offset-3">                                                             
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