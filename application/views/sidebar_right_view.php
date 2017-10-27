<div class="sidebar-right">
    <div class="offcanvas">
        <div class="sidebar-header">
            <div class="icon-wrap"><a id="sidebar-chat-mb-close" href="javascript:void(0);"><i class="material-icons">clear</i></a></div>
            <div class="text-box-mb">
                <span>Chat</span> 
            </div>
        </div>
        <div class="offcanvas-wrapper">
            <div class="offcanvas-content">
                <div class="viewport">
                    <div class="content">
                        <div class="sidebar-header-profile">
                            <div class="header-profile-bg">
                                <div class="header-profile-chat"><i class="material-icons md-48">chat</i></div>
                            </div>
                        </div>
                        <div class="media-list media-list-contact">
                        <?php $online = date('Y-m-d H:i:s',time()-5*60);//last 5 minutes
                            foreach($users as $user){ if($user->user_id != $cur_user->user_id ){
                            $birthday = date('m-d', strtotime($user->user_birthday));
                            $currentdate = date('Y-m-d');
                            $checkcurdate = date('m-d', strtotime($currentdate));
                        ?>
                        <a class="media" data-toggle="show-chat" href="javascript:void(0)">   
                            <span class="media-object pull-left">
                                <span class="badge badge-primary up" rel="<?php echo $user->user_id; ?>"><?php echo $user->unread;?></span>
                                <img src="<?php echo base_url().'assets/img/avatars/'.$user->user_avatar;?>" alt="avatar" class="img-circle">
                            </span>
                            <span class="media-body">
                                <span class="media-heading">
                                    <input type="hidden" value="<?php echo $user->user_id; ?>" name="user_id" />
                                    <?php if($birthday == $checkcurdate && $user->time > $online){
                                        echo '<i class="material-icons green-cake">cake</i>';                                                
                                    } elseif ($birthday == $checkcurdate && $user->time < $online){
                                        echo '<i class="material-icons red-cake">cake</i>';  
                                    } else { ?>
                                    <span class="userstatus material-icons donut_large <?php if($user->time > $online){echo 'avatar-online';} else {echo 'avatar-away';}?>"></span>
                                    <?php } ?>        
                                    <?php if($user->user_permissions == 4){
                                        echo '<span class="text-lt">'.$user->user_name.'</span>';
                                    }else{
                                    echo $user->user_name;
                                    }?>                                            
                                </span>
                                <span class="media-desc"><?php echo $user->aboutme;?></span> 
                            </span>           
                        </a>            
                        <?php }} ?>    
                        </div>     
                    </div>
                </div>
            </div>
            <div id="conversation" class="conversation">    
                <div class="conversation-header">
                    <div class="icon-wrap">
                        <a class="conversation-return" href="javascript:void(0)" data-toggle="close-chat"><i class="material-icons md-18">chevron_left</i></a>
                    </div>
                    <div class="conversation-title"></div>
                    <div class="conversation-status"></div>
                </div> 
                <div class="conversation-footer">        
                    <div class="input-chat">            
                        <input class="form-control" name="comments"  id="comments" type="text" placeholder="<?php echo lang('sbar_chat_textarea_placeholder');?>">            
                    </div>
                </div>   
                <input type="hidden" name="chat_buddy_id" id="chat_buddy_id"/>
                <div class="viewport">
                    <div class="chat-container">                        
                        <ul class="media-list media-list-bubble"></ul>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div>
