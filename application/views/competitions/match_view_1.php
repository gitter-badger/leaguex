<section id="main-wrapper">
    <div class="container-fluid animsition pad-dyn">
        <?php foreach ($match as $matchid): ?>
        <div class="row">
            <div class="col-1">
                <div class="col-lg-7">
                    <div class="match-box">
                        <div class="match-box-header">
                            <div class="match-info"><?php echo lang('match_day_title');?> <?php echo $matchid->matchday_name;?></div>
                        </div>
                         <?php $this->load->view('modals/add_result_form');?>
                        <div class="match-box-score-wrap">
                            <div class="wrapper">
                                <div class="match-box-teams">
                                    <div class="home team">
                                        <a href="#" class="team-logo-container">
                                            <img class="team-logo-85" src="<?= base_url().'assets/img/teams_logo/'.$matchid->logo1;?>">
                                            <img class="team-logo-65" src="<?= base_url().'assets/img/teams_logo/'.$matchid->logo1;?>">
                                        </a>
                                        <a href="#" class="team-name"><?php echo $matchid->team1;?></a>
                                    </div>
                                    <div class="score-container">
                                        <?php if($matchid->match_status == 0){?>
                                        <div class="advice-text"><?php echo lang('match_day_advice_text');?></div>
                                        <div class="unplayed"><img class="" src="<?= base_url().'assets/img/timer-clock.png';?>"></div>
                                        <?php }else{ ?>
                                            <div class="score"><span class="home-score"><?php echo ($matchid->match_status == 0 ? '' : $matchid->match_score1);?></span><span class="score-space">-</span><span class="away-score"><?php echo ($matchid->match_status == 0 ? '' : $matchid->match_score2);?></span></div>
                                        <?php } ?>
                                    </div>
                                    <div class="away team">
                                        <a href="#" class="team-logo-container">
                                            <img class="team-logo-85" src="<?= base_url().'assets/img/teams_logo/'.$matchid->logo2;?>">
                                            <img class="team-logo-65" src="<?= base_url().'assets/img/teams_logo/'.$matchid->logo2;?>">
                                        </a>
                                        <a href="#" class="team-name"><?php echo $matchid->team2;?></a>
                                    </div>
                                </div>
                                <div class="match-box-events-container  <?php if($matchid->match_status == 1){echo 'showline';}?>">
                                    <div class="home-scorer">
                                        <?php foreach($homescorer as $hscorer): ?>
                                        <a href="#" class="event">
                                            <div class="scorer"><?php echo $hscorer->homeplayer;?> <span><?php echo $hscorer->timescore;?></span></div>
                                        </a>
                                        <?php  endforeach; ?>
                                    </div>
                                    <div class="away-scorer">
                                        <?php foreach ($awayscorer as $ascorer): ?>
                                        <a href="#" class="event">
                                            <div class="scorer"><?php echo $ascorer->awayplayer;?> <span><?php echo $ascorer->timescore;?></span></div>
                                        </a>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="home-event">
                                        <?php foreach($homevent as $hevent): ?>
                                        <a href="#" class="event <?php echo $hevent->uniclass;?>" aria-hidden="true" data-icon="<?php echo $hevent->unievicon;?>">
                                            <div class="eventinfo"><?php echo $hevent->homeplayer;?> <span><?php echo $hevent->timevent;?>'</span></div>
                                        </a>
                                        <?php  endforeach; ?>
                                    </div>
                                    <div class="away-event">
                                        <?php foreach($awayevent as $aevent): ?>
                                        <a href="#" class="event <?php echo $aevent->uniclass;?>" aria-hidden="true" data-icon="<?php echo $aevent->unievicon;?>">
                                            <div class="eventinfo"><?php echo $aevent->awayplayer;?> <span><?php echo $aevent->timevent;?>'</span></div>
                                        </a>
                                        <?php  endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>                
                    </div> 
                </div>
            
        <?php endforeach; ?>  
       
            <div class="col-lg-5">
                    <div class="panel">
                        <div class="comments-widget">
                            <div class="comment-form-container">
                                <form id="commentForm" method="POST" action="" name="commentform">
                                    <div class="comment-form">
                                        <img class="user-image" src="<?php if (substr($userPic, 0, 5) === 'https'){echo $userPic;}else{echo base_url().'assets/img/avatars/'.$userPic;}?>" alt="userimage">
                                        <div class="comment-box-container">
                                            <div class="comment-box">
                                                <textarea id="textcontent" autocomplete="off" placeholder="Aggiungi un commento..."></textarea>
                                                <input type="hidden" id="userid" value="<?php echo $this->session->userdata('userid'); ?>">
                                                <input type="hidden" id="matchid" value="<?php echo $matchid->match_id;?>">
                                                <input type="hidden" id="imageid" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="image-comment-wrap">
                                        <div class="image-comment-container">
                                            <ul class="image-comment">
                                                <div class="image-comment-left">
                                                    <div class="image">
                                                        <li class="preview">
                                                            <div class="loading-container" data-img="<?php echo site_url("assets/img/users_images/");?>" data-url="<?php echo site_url("competitions/match/upload_handler");?>" data-id="<?php echo $matchid->match_id;?>" id="image-preview">
                                                                <div class="loader loadimage mt-25"></div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <img id="thumbImg" alt="">
                                                        </li>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="comment-footer">
                                        <div class="footer-actions" id="upload">
                                            <button type="button" id="submitImagesComment" class="btn btn-fab btn-fab-custom no-shadow no-color-bg"><i class="material-icons">camera_alt</i></button>
                                        </div>
                                        <button type="button" id="submitComment" class="btn btn-info"><span>Pubblica</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>    
                        <div class="comments-container">
                            <ul class="comments-list">
                                <?php foreach ($comments as $comment):
                                     $contentPost = htmlentities($comment->comment_content);
                                ?>                                                         
                                <li class="comment">
                                    <a class="comment-avatar pull-left"><img src="<?= base_url().'assets/img/avatars/'.$comment->user_avatar;?>"></a>
                                    <div class="comment-text-container">
                                        <div class="comment-user">
                                            <a class="comment-user-name"><?php echo $comment->user_name;?></a>
                                        </div>
                                        <div class="comment-text"><?php echo auto_link($contentPost);?></div>
                                        <a class="imageBox <?php if($comment->comment_image_id == null){echo 'hide';} ;?>" href="<?= base_url().'assets/img/users_images/'.$comment->comment_image_id;?>" data-lightbox="<?php echo $comment->comment_image_id;?>">
                                            <div class="resp-image-comment-wrap">
                                                <div class="resp-image-comment-container" style="max-width: 260px;">
                                                    <div class="resp-image-comment">
                                                        <img id="imgresp" src="<?= base_url().'assets/img/users_images/'.$comment->comment_image_id;?>" alt="userimage">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="comment-actions-container">
                                        <ul class="comment-actions">
                                            <li class="comment-time"><span><?php echo time_convert($comment->time);?></span></li>
                                            <li class="dropdown comment-menu">
                                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><i class="material-icons md-18">more_vert</i></a>
                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                        <li>
                                                            <a class="delete" data-id="<?php echo $comment->comment_id;?>" href="#">Elimina Commento</a>
                                                        </li>
                                                        <li>
                                                            <a class="animsition-link ripple-effect" href="#">Segnala Commento</a>
                                                        </li>
                                                    </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <?php endforeach; ?>    
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>
        </div>
       
    </div>
</section>
<div class="float-button">
    <a href="javascript:void(0);" id="addResult" class=" btn btn-danger btn-fab options-btn "><i class="material-icons">mode_edit</i></a>
</div>

