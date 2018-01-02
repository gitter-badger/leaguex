<section id="main-wrapper" class="main">
    <div class="animsition container-fluid pad-dyn">
        <div class="row">
            <div class="col-1">
                <div class="col-lg-10">
                    <div class="filter-custom">
                        <div class="filter-wrap">
                            <select class="selectpicker m-r-a" data-width="fit" id="selectNotifications" name="notifications" data-toggle="dropdown">
                                <option value="1"><?php echo lang('select_all_note')?></option>
                                <option value="2"><?php echo lang('select_unread_note')?></option>
                                <option value="3"><?php echo lang('select_read_note')?></option>
                            </select>
                            <div class="markall btn btn-fab btn-fab-mini no-shadow no-color-bg">
                                <i class="material-icons">done_all</i>
                            </div>
                        </div>
                    </div>
                    <div class="notes-wrap" id="notes">
                        <input type="hidden" value="<?php echo $this->session->userdata('userid')?>" name="userid">
                        <div class="no-note-wrap">
                            <div class="no-note-container">
                                <div class="no-note">
                                    <img src="<?= base_url().'assets/img/no-note.png'?>" width="100" height="100">
                                    <div class="no-note-text"><?php echo lang('no_note_text')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="notes-list"></div>
                        <div class="loadmore"><div class="morenote"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>