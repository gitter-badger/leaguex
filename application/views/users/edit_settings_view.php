<section id="main-wrapper" class="main">
    <div class="animsition container-fluid pad-dyn"> 
        <?php foreach ($user as $userid): ?>
        <div class="row">
            <div class="col-1">
                <div class="col-lg-7">
                    <div id="profile-page" class="panel">
                        <div class="user-profile-bg">
                            <div class="preview">
                                <div class="loading-container" data-img="<?php echo site_url("assets/img/avatars/");?>" data-url="<?php echo site_url("users/edit_settings/upload_handler");?>" data-id="<?php echo $userid->user_id?>" id="image-preview">
                                    <div class="loader loadimage"></div>
                                </div>
                            </div>
                            <div class="profile-avatar-wrap">
                                <img id="thumbImg" src="<?php if (substr($userid->user_avatar, 0, 5) === 'https'){echo $userid->user_avatar;}else{echo base_url().'assets/img/avatars/'.$userid->user_avatar;}?>" alt="Avatar">
                                <div class="profile-avatar-btn" id="upload">
                                    <div class="icon-wrap"><i class="material-icons">camera_alt</i></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="user-profile-info">
                                <div class="user-profile-name"><?php echo $userid->user_name?></div>
                                <div class="user-profile-role">
                                <?php if($userid->user_permissions == 1){
                                    echo '<span class="label label-orange">'.lang('select_user_group_1').'</span>';
                                    }elseif ($userid->user_permissions == 2){
                                    echo '<span class="label label-primary">'.lang('select_user_group_2').'</span>';                                        
                                    }elseif ($userid->user_permissions == 3){
                                    echo '<span class="label label-success">'.lang('select_user_group_3').'</span>';
                                    }elseif ($userid->user_permissions == 4){
                                    echo '<span class="label label-danger">'.lang('select_user_group_4').'</span>';
                                }?>
                                </div>
                            </div>
                            <div class="user-profile-about"><?php if($userid->aboutme == null){echo lang('esett_avatar_widget_personal_message');}else{echo $userid->aboutme;}?></div>
                        </div>                       
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="panel">
                        <header class="panel-heading-custom">
                            <div class="panel-title-custom"><?php echo lang('esett_header_box_account');?></div>
                            <div class="edit-button">
                                <a href="javascript:void(0)" id="editAccount" data-id="<?php echo $userid->user_id?>" class="btn withripple"><i class="material-icons">mode_edit</i></a>
                            </div>
                            <?php $this->load->view('modals/edit_user_account_form'); ?>
                        </header>
                        <div class="panel-body useraccount pad-t-5">
                            <div id="custom-box">
                                <ul class="list-custom list-unstyled">
                                    <li><div class="list-title"><?php echo lang('esett_title_box_username');?></div><div class="list-desc" id="usernameAccount"><?php echo $userid->user_name;?></div></li>
                                    <li><div class="list-title"><?php echo lang('esett_title_box_email');?></div><div class="list-desc" id="emailAccount"><?php echo $userid->user_email;?></div></li>
                                    <li><div class="list-title"><?php echo lang('esett_title_box_birthday');?></div><div class="list-desc" id="birthdayAccount"><?php echo date("d/m/Y", strtotime($userid->user_birthday));?></div></li>
                                    <li><div class="list-title"><?php echo lang('esett_title_box_city');?></div><div class="list-desc" id="cityAccount"><?php if($userid->user_city == null){echo lang('esett_desc_box_no_data');}else{echo $userid->user_city;}?></div></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-1">
                <div class="col-lg-7">
                    <div class="panel">
                        <header class="panel-heading-custom">
                            <div class="panel-title-custom"><?php echo lang('esett_header_box_account');?></div>
                            <div class="edit-button">
                                <a href="javascript:void(0)" id="editAccount" data-id="<?php echo $userid->user_id?>" class="btn withripple"><i class="material-icons">mode_edit</i></a>
                            </div>
                        </header>
                        <div class="panel-body useraccount pad-t-5">
                            <div id="custom-box">
                                <ul class="list-custom list-unstyled">
                                    <li><div class="list-title"><?php echo lang('esett_title_box_username');?></div><div class="list-desc" id="usernameAccount"><?php echo $userid->user_name;?></div></li>
                                    <li><div class="list-title"><?php echo lang('esett_title_box_email');?></div><div class="list-desc" id="emailAccount"><?php echo $userid->user_email;?></div></li>
                                    <li><div class="list-title"><?php echo lang('esett_title_box_birthday');?></div><div class="list-desc" id="birthdayAccount"><?php echo date("d/m/Y", strtotime($userid->user_birthday));?></div></li>
                                    <li><div class="list-title"><?php echo lang('esett_title_box_city');?></div><div class="list-desc" id="cityAccount"><?php if($userid->user_city == null){echo lang('esett_desc_box_no_data');}else{echo $userid->user_city;}?></div></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="panel">
                        <header class="panel-heading-custom">
                            <div class="panel-title-custom"><?php echo lang('esett_header_box_info');?></div>
                            <div class="edit-button">
                                <a href="javascript:void(0)" id="editInfo" data-id="<?php echo $userid->user_id?>" class="btn withripple"><i class="material-icons">mode_edit</i></a>
                            </div>
                            <?php $this->load->view('modals/edit_user_info_form'); ?>
                        </header>
                        <div class="panel-body userinfo pad-t-5">
                            <div id="custom-box">
                                <ul class="list-custom list-unstyled">
                                    <li><div class="list-title"><?php echo lang('esett_title_box_skype');?></div><div class="list-desc" id="skypeInfo"><?php if($userid->skype_tag == null){echo lang('esett_desc_box_no_data');}else{echo $userid->skype_tag;}?></div></li>
                                    <li><div class="list-title"><?php echo lang('esett_title_box_xbox');?></div><div class="list-desc" id="xboxInfo"><?php if($userid->xbox_tag == null){echo lang('esett_desc_box_no_data');}else{echo $userid->xbox_tag;}?></div></li>
                                    <li><div class="list-title"><?php echo lang('esett_title_box_psn');?></div><div class="list-desc" id="psnInfo"><?php if($userid->psn_tag == null){echo lang('esett_desc_box_no_data');}else{echo $userid->psn_tag;}?></div></li>
                                    <li><div class="list-title"><?php echo lang('esett_title_box_favorite_club');?></div><div class="list-desc" id="favoriteClubInfo"><?php if($userid->favorite_club == null){echo lang('esett_desc_box_no_data');}else{echo $userid->favorite_club;}?></div></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>   
    </div>      
</section> 