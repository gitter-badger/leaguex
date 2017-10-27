<section id="main-wrapper">
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                <h4 class="page-title"><?php echo lang('admin_oplayers_header_title');?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><?php echo lang('admin_oplayers_header_title');?></li>
                    </ol>
                </div>
            </div>     
        </div>
        <div class="row">
            <div class="col-md-12 animsition">
                <div class="panel">
                    <form action="<?php echo site_url("admin/settings/options_players/update_players_options");?>" method="post" role="form" name="updatePlayersOptions" id="updatePlayersOptions" autocomplete="off" class="form-horizontal fv-form fv-form-bootstrap">
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_oplayers_title_url_stats');?></h2>                          
                            <span class="panel-heading-desc"><?php echo lang('admin_oplayers_description_url_stats');?></span>                            
                        </header>
                        <div class="panel-body pad-t-0">
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_oplayers_input_url_stats');?>:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="urlStats" name="urlStats" placeholder="<?php echo lang('admin_oplayers_input_placeholder_url_stats');?>" value="<?php echo $option->url_stats;?>">
                                </div>
                            </div>                           
                        </div>
                        <header class="panel-heading">
                            <h2><?php echo lang('admin_oplayers_title_url_player_image');?></h2>
                            <span class="panel-heading-desc"><?php echo lang('admin_oplayers_description_url_player_image');?></span>                            
                        </header>
                        <div class="panel-body pad-t-0">
                            <div class="form-group">                                
                                <label class="col-sm-3 control-label"><?php echo lang('admin_oplayers_input_url_player_image');?>:</label>
                                <div class="col-sm-6">     
                                    <textarea class="form-control" id="urlImage" name="urlImage" placeholder="<?php echo lang('admin_oplayers_input_placeholder_url_player_image');?>" rows="5"><?php echo $option->url_image;?></textarea>
                                </div>                               
                            </div>
                            <div class="form-group">                                                                       
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