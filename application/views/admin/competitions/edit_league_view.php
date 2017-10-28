<section id="main-wrapper">
    <div class="container-fluid">
        <?php foreach ($league as $leagueid):?>
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                <h4 class="page-title"><?php echo lang('admin_eleague_header_title');?> <?php echo $leagueid->competition_name;?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><a class="animsition-link" href="<?= base_url().'admin/competitions/leagues_list';?>"><?php echo lang('admin_leagueslist_header_title');?></a></li>
                        <li><?php echo lang('addresult_title_goal_scorers');?></li>
                    </ol>
                </div>
            </div>     
        </div>
        <?php endforeach;?> 
        <div class="row animsition">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <?php foreach ($league as $leagueid):?>
                        <div class="widget-details">
                            <div class="competition-logo-img">
                                <div class="preview">
                                    <div class="loading-container" data-img="<?php echo site_url("assets/img/competitions_logo/");?>" data-url="<?php echo site_url("admin/competitions/edit_league/upload_handler");?>" data-id="<?php echo $leagueid->competition_id ?>" id="image-preview">
                                        <div class="loader loadimage"></div>
                                    </div>
                                </div>
                                <img id="thumbImg" src="<?php if (substr($leagueid->competition_logo, 0, 5) === 'https'){echo $leagueid->competition_logo;}else{echo base_url().'assets/img/competitions_logo/'.$leagueid->competition_logo;}?>" alt="Logo">    
                            </div>
                            <div class="upload-logo" id="upload">                                    
                                <button type="button" class="btn btn-fab btn-fab-custom btn-danger"><i class="material-icons">camera_alt</i></button>
                            </div>
                            <div class="info-wrap">    
                                <div class="competition-name">
                                    <a href="#" id="competitionName" data-name="competitioname" data-type="text" data-pk="<?php echo $leagueid->competition_id;?>" data-url="<?php echo site_url("admin/competitions/edit_league/update_league");?>" data-title="Enter league name"><?php echo $leagueid->competition_name;?> <i class="material-icons mode_edit"></i></a>
                                </div>
                                <div class="info-list">
                                    <ul class="col-1">
                                        <li>
                                            <div class="info-label"><?php echo lang('table_header_creation_date');?></div>
                                            <div class="info-desc"><?php echo date("d/m/Y", strtotime($leagueid->competition_registration_date));?></div>
                                        </li>
                                        <li>
                                            <div class="info-label"><?php echo lang('admin_eleague_info_matchday');?></div>
                                            <div class="info-desc"><?php echo $leagueid->countmatchday;?></div>
                                        </li>
                                        <li>
                                            <div class="info-label"><?php echo lang('admin_eleague_info_matches');?></div>
                                            <div class="info-desc"><?php echo $leagueid->countmatches;?></div>
                                        </li>
                                    </ul>
                                    <?php endforeach;?> 
                                    <ul class="col-2">
                                        <?php foreach ($getmatchplayed as $matchplayed):?>
                                        <li>
                                            <div class="info-label"><?php echo lang('admin_eleague_info_played');?></div>
                                            <div class="info-desc"><?php echo $matchplayed->matchplayed;?></div>
                                        </li>
                                        <?php endforeach;?>
                                        <?php foreach ($getmatchnotplayed as $matchnotplayed):?>
                                         <li>
                                            <div class="info-label"><?php echo lang('admin_eleague_info_unplayed');?></div>
                                            <div class="info-desc"><?php echo $matchnotplayed->matchnotplayed;?></div>
                                        </li>
                                        <?php endforeach;?> 
                                    </ul>
                                    <?php foreach ($league as $leagueid):?>
                                    <ul class="col-3">
                                        <li class="info-stack">
                                            <div class="info-label"><?php echo lang('admin_eleague_info_activate_league');?></div>
                                            <div class="togglebutton">
                                                <label>
                                                    <input id="activeLeague" name="activeleague" type="checkbox" value="<?php echo $leagueid->competition_status;?>" data-id="<?php echo $leagueid->competition_id;?>" <?php if($leagueid->competition_status == 1){echo 'checked="checked"';}?>>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?> 
                    </div>
                    <?php $this->load->view('admin/modals/edit_match_form');?>
                    <div class="panel-body pad-t-0">
                        <input type="hidden" name="getleagueid" value="<?php echo $this->uri->segment(5);?>">
                        <table class="table dataTable width-full responsive nowrap" id="editLeague">
                            <thead>
                                <th>Day</th>
                                <th style="visibility:hidden"></th>
                                <th><?php echo lang( 'admin_eleague_header_table_home_team');?></th>
                                <th><?php echo lang( 'admin_eleague_header_table_score');?></th>
                                <th><?php echo lang( 'admin_eleague_header_table_away_team');?></th>
                            </thead>                            
                            <tbody></tbody>
                        </table>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
