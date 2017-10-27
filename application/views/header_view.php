<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="theme-color" content="#03a9f4">
        <title><?php echo $title?></title>
        <?php echo put_headers();?>
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'> 
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
	<![endif]-->       
    </head>
    <body>
        <div class="wrap">
            <div class="header-container">
                <header id="header" class="navbar">
                    <div class="navbar-toolbar <?php if(isset($page)){ echo 'options-bar';}?>">
                        <div class="button-menu-container">
                             <?php if((isset($page)) && ($this->uri->segment(3)== $page)){?><a href="<?= base_url().$backlink;?>" class="button-collapse back-page animsition-link"><i class="material-icons">arrow_back</i></a><?php } ?>
                            <a href="javascript:void(0);" class="button-collapse menu-bar" id="navbar-left"><i class="material-icons">menu</i></a>    
                        </div>
                        <div class="toolbar-left">
                            <div class="brand-box">
                                <a href="<?= base_url().'home';?>"></a>
                                <div class="navbar-title"><?php echo $title?></div>
                            </div>
                        </div>
                        <div class="toolbar-right">
                            <div class="dropdown-wrap">
                                <div class="dropdown notifications">
                                    <a href="javascript:void(0);" class="dropdown-toggle dropdown-notify" data-toggle="dropdown"><i class="material-icons">notifications</i>
                                    <input type="hidden" value="<?php echo $this->session->userdata('userid')?>" name="user_id" />
                                    <span class="badge badge-danger totalntf"><?php if($unreadntf > 0){echo $unreadntf;}?></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right notes-widget">
                                        <header class="notification-header">
                                            <div class="notification-header-title ntfcount">
                                                <?php if($unreadntf == 1){
                                                    echo sprintf(lang('unread_ntf'),$unreadntf);}
                                                else if ($unreadntf == 0){
                                                    echo sprintf(lang('all_read_ntf'),$unreadntf);}    
                                                else {
                                                    echo sprintf(lang('all_unread_ntf'),$unreadntf);}    
                                                ?>
                                            </div>
                                        </header>
                                        <div class="notification-body-wrap">
                                            <div class="notification-body"></div>
                                            <div id="loadnote" style="margin-top: 5px;"><div class="loader loadpage"></div></div>
                                        </div>
                                        <div class="notification-footer withripple"><a href="<?= base_url().'notifications/notes';?>" class="animsition-link">Check all notifications</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown navbar-chat">
                                    <a href="javascript:void(0);" class="chat-toggle" id="sidebarChat"><i class="material-icons">chat</i>
                                        <span class="badge badge-danger totalmsg"><?php if($unreadmsg > 0){echo $unreadmsg;}?></span>
                                    </a>
                                </div>
                                <div class="dropdown profile">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="img-profile"><img src="<?php if (substr($userPic, 0, 5) === 'https'){echo $userPic;}else{echo base_url().'assets/img/avatars/'.$userPic;}?>" alt="avatar"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <?php if($this->session->userdata('permissions') == 1){?> 
                                    <li>
                                        <a class="animsition-link" href="<?= base_url().'admin/home';?>"><span class="icon"><i class="material-icons">dashboard</i></span><?php echo lang('head_menu_admin');?></a>
                                    </li>
                                    <?php } ?>
                                    <li>
                                        <a class="animsition-link" href="<?= base_url().'users/edit_settings/userid/'.$this->session->userdata("userid");?>/"><span class="icon"><i class="material-icons">settings</i></span><?php echo lang('head_menu_settings');?></a>
                                    </li>
                                    <li>
                                        <a class="animsition-link" href="<?=site_url('sign/signin/logout')?>"><span class="icon"><i class="material-icons">power_settings_new</i></span>Logout</a>
                                    </li>                            
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($this->uri->segment(2)=="test"){ ?>
                    <div class="nav-tabs-bar">
                        <div class="tab-container withripple active">
                            <a class="withoutripple" data-toggle="tab" href="#profile-settings">Profilo</a>
                        </div>    
                        <div class="tab-container withripple">
                            <a class="withoutripple" data-toggle="tab" href="#notifications" id="note-tab"><input type="hidden" value="<?php echo $this->session->userdata('userid')?>" name="user_id" /><?php echo lang('esett_tab_notifications');?></a>
                        </div>    
                    </div>
                    <?php } ?>
                    <input type="hidden" id="check-transition" name="transition" value="<?php echo $transition?>">
                </header>
            </div>        