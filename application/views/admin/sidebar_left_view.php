<div class="sidebar-left sidebar-menu">
    <div class="sidebar-header">
        <div class="brand-box-mb"></div>
        <div class="icon-wrap"><a id="sidebar-mb-close" href="javascript:void(0);"><i class="material-icons">clear</i></a></div>
    </div>
    <div class="sidebar-container">
        <div class="sidebar-header-profile">
            <div class="header-profile-bg">
                <div class="header-profile-avatar">
                     <img src="<?php if (substr($userPic, 0, 5) === 'https'){echo $userPic;}else{echo base_url().'assets/img/avatars/'.$userPic;}?>" alt="avatar">
                </div>
                <div class="header-profile-info"><?php echo $this->session->userdata('username')?></div>
            </div>
        </div>
        <div class="sidebar-content">
            <div class="content">
                <div class="content-menu withripple">
                    <a class="animsition-link" href="<?= base_url().'home';?>">
                        <div class="icon-wrap"><i class="material-icons">reply</i></div>
                        <div class="text"><?php echo lang('admin_sbar_menu_go_to_site');?></div>
                    </a>
                </div>
                <div class="content-menu withripple <?php if($this->uri->segment(2)=="home"){echo "active";}?>">
                    <a class="animsition-link" href="<?= base_url().'admin/home';?>">
                        <div class="icon-wrap"><i class="material-icons">home</i></div>
                        <div class="text"><?php echo lang('admin_sbar_menu_home');?></div>
                    </a>
                </div>
                <div class="content-menu withripple <?php if($this->uri->segment(2)=="settings"){echo "menu-open active";}?>">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <div class="icon-wrap"><i class="material-icons">settings</i></div>
                        <div class="text"><?php echo lang('admin_sbar_menu_config');?></div>
                    </a>
                </div>
                <div class="submenu" <?php if($this->uri->segment(2)=="settings"){echo "style='display:block;'";}?>>
                    <div class="content-menu withripple">
                        <a class="animsition-link <?php if($this->uri->segment(3)=="options_general"){echo "active";}?>" href="<?= base_url().'admin/settings/options_general';?>">
                            <span class="text"><?php echo lang('admin_sbar_submenu_options_general');?></span>
                        </a> 
                    </div>
                    <div class="content-menu withripple">
                        <a class="animsition-link <?php if($this->uri->segment(3)=="options_email"){echo "active";}?>" href="<?= base_url().'admin/settings/options_email';?>">
                            <span class="text"><?php echo lang('admin_sbar_submenu_options_email');?></span>
                        </a> 
                    </div>
                    <div class="content-menu withripple">
                        <a class="animsition-link <?php if($this->uri->segment(3)=="options_media"){echo "active";}?>" href="<?= base_url().'admin/settings/options_media';?>">
                            <span class="text"><?php echo lang('admin_sbar_submenu_options_media');?></span>
                        </a> 
                    </div>
                    <div class="content-menu withripple">
                        <a class="animsition-link <?php if($this->uri->segment(3)=="options_competitions"){echo "active";}?>" href="<?= base_url().'admin/settings/options_competitions';?>">
                            <span class="text"><?php echo lang('admin_sbar_submenu_options_competitions');?></span>
                        </a> 
                    </div>
                    <div class="content-menu withripple">
                        <a class="animsition-link <?php if($this->uri->segment(3)=="options_players"){echo "active";}?>" href="<?= base_url().'admin/settings/options_players';?>">
                            <span class="text"><?php echo lang('admin_sbar_submenu_options_players');?></span>
                        </a> 
                    </div> 
                </div>                    
                <div class="content-menu withripple <?php if($this->uri->segment(2)=="users"){echo "active";}?>">
                    <a class="animsition-link" href="<?= base_url().'admin/users/users_list';?>">
                        <div class="icon-wrap"><i class="material-icons">face</i></div>
                        <div class="text"><?php echo lang('admin_sbar_menu_users');?></div>
                    </a>
                </div>
                <div class="content-menu withripple <?php if($this->uri->segment(2)=="competitions"){echo "menu-open active";}?>">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <div class="icon-wrap"><i class="material-icons">stars</i></div>
                        <div class="text"><?php echo lang('admin_sbar_menu_competitions');?></div>
                    </a>
                </div>
                <div class="submenu" <?php if($this->uri->segment(2)=="competitions"){echo "style='display:block;'";}?>>
                    <div class="content-menu withripple">
                        <a class="animsition-link <?php if($this->uri->segment(3)=="leagues_list"){echo "active";}?>" href="<?= base_url().'admin/competitions/leagues_list';?>">
                            <span class="text"><?php echo lang('admin_sbar_submenu_leagues');?></span>
                        </a> 
                    </div>
                    <div class="content-menu withripple">
                        <a class="animsition-link <?php if($this->uri->segment(3)=="cups"){echo "active";}?>" href="<?= base_url().'admin/competitions/cups_list';?>">
                            <span class="text"><?php echo lang('admin_sbar_submenu_cups');?></span>
                        </a> 
                    </div>
                </div>
                <div class="content-menu withripple <?php if($this->uri->segment(2)=="teams"){echo "active";}?>">
                    <a class="animsition-link" href="<?= base_url().'admin/teams/teams_list';?>">
                        <div class="icon-wrap"><i class="material-icons">security</i></div>
                        <div class="text"><?php echo lang('admin_sbar_menu_teams');?></div>
                    </a>
                </div>
                <div class="content-menu withripple <?php if($this->uri->segment(2)=="managers"){echo "active";}?>">
                    <a class="animsition-link" href="<?= base_url().'admin/managers/managers_list';?>">
                        <div class="icon-wrap"><i class="material-icons">person</i></div>
                        <div class="text"><?php echo lang('admin_sbar_menu_managers');?></div>
                    </a>
                </div> 
                 <div class="content-menu withripple <?php if($this->uri->segment(2)=="players"){echo "active";}?>">
                    <a class="animsition-link" href="<?= base_url().'admin/players/players_list';?>">
                        <div class="icon-wrap"><i class="material-icons">people</i></div>
                        <div class="text"><?php echo lang('admin_sbar_menu_players');?></div>
                    </a>
                </div>   
            </div>
        </div>    
    </div>
</div>