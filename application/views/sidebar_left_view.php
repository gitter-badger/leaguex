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
                <div class="content-menu withripple <?php if($this->uri->segment(1)=="home"){echo "active";}?>">
                    <a class="animsition-link" href="<?= base_url().'home';?>">
                        <div class="icon-wrap"><i class="material-icons">home</i></div>
                        <div class="text">Home</div>
                    </a>
                </div>
                <?php if($this->session->userdata('manager') != null){ ?>
                <div class="content-menu withripple <?php if($this->uri->segment(1)=="teams"){echo "active";}?>">
                    <a style="color: #f44336 !important;" class="animsition-link" href="<?= base_url().'teams/user_team/userid/'.$this->session->userdata('userid');?>">
                        <div class="icon-wrap"><i class="flaticon flaticon-game" style="font-size: 22px; color:#f44336 !important"></i></div>
                        <div class="text"><?php echo lang('sbar_menu_team');?></div>
                    </a>
                </div>
                <?php } ?>
                <div class="content-menu withripple <?php if($this->uri->segment(1)=="competitions"){echo "menu-open active";}?>">
                    <a class="animsition-link" href="<?= base_url().'competitions/leagues';?>">
                        <div class="icon-wrap"><i class="flaticon flaticon-cup"></i></div>
                        <div class="text"><?php echo lang('sbar_menu_leagues');?></div>
                    </a>
                </div>
                
            </div> 
            <div class="content-menu withripple <?php if($this->uri->segment(1)=="users"){echo "active";}?>">
                <a class="animsition-link" href="<?= base_url().'users/edit_settings/userid/'.$this->session->userdata("userid");?>">
                    <div class="icon-wrap"><i class="material-icons">settings</i></div>
                    <div class="text"><?php echo lang('sbar_menu_settings');?></div>
                </a>
            </div>
            <div class="content-menu withripple <?php if($this->uri->segment(1)=="notifications"){echo "active";}?>">
                <a class="animsition-link" href="<?= base_url().'notifications/notes';?>">
                    <div class="icon-wrap"><i class="material-icons">notifications</i></div>
                    <div class="text"><?php echo lang('sbar_menu_notifications');?></div>
                </a>
            </div>
        </div>
    </div>
</div>