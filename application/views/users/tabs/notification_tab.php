<div class="tab-pane fade notify-tab" id="notifications">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="notification-header">
                    <span class="title ntfcount"><?php if($unreadntf == 1){
                    echo sprintf(lang('unread_ntf'),$unreadntf);}
                    else if ($unreadntf == 0){
                    echo sprintf(lang('all_read_ntf'),$unreadntf);}    
                    else {
                    echo sprintf(lang('all_unread_ntf'),$unreadntf);}    
                    ?></span>
                    <?php if ($countntf > 0){?>
                    <div class="markall">
                        <span class="btn btn-fab btn-fab-mini no-shadow no-color-bg"><i class="material-icons">done_all</i></span>    
                    </div>
                    <?php } ?>
                </div>
                <div id="loading" class="loading-block loadpage"></div>
                <div class="media-list hide-block"></div>
            </div>
        </div>
    </div>
</div>