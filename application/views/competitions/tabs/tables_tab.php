<div class="tab-pane" id="tables">
    <div class="row">
        <div class="col-1">
            <div class="col-lg-10">
                <div class="filter-custom">
                    <div class="filter-wrap">
                        <select class="show-tick selectpicker m-r-a" data-width="fit" id="selectLeaguesTables" name="leaguename" <?php if(!is_array($getlastleague)){echo 'disabled';} ?> data-none-selected-text="<?php echo lang('league_select_all_tables');?>"></select>
                        
                    </div>
                </div>    
                <div id="tables">
                    <?php if(!is_array($getlastable)){ ?>
                    <div class="no-tables-wrap">
                        <div class="no-tables-container">
                            <div class="no-tables">
                                <img src="<?= base_url().'assets/img/no-tables.png'?>" width="100" height="100">
                                <div class="no-tables-text"><?php echo lang('no_tables_text')?></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(is_array($getlastable)){ ?>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="tables-heading">
                                <div class="tables-competition-logo"><?php foreach($getlastable as $showtable): ?><img src="<?= base_url().'assets/img/competitions_logo/'.$showtable->competitionlogo;?>"></div><div class="tables-competition-name"><?php echo $showtable->competitioname;?><?php break; endforeach; ?></div>
                            </div>
                            <div class="table-custom">
                                <div class="th">
                                    <div class="td m-l-5">Pos</div>
                                    <div class="td"><?php echo lang('league_header_table_played');?></div>
                                    <div class="td sm-hide"><?php echo lang('league_header_table_won');?></div>
                                    <div class="td sm-hide"><?php echo lang('league_header_table_drawn');?></div>
                                    <div class="td sm-hide"><?php echo lang('league_header_table_lost');?></div>
                                    <div class="td"><?php echo lang('league_header_table_goals_for');?></div>
                                    <div class="td"><?php echo lang('league_header_table_goals_against');?></div>
                                    <div class="td"><?php echo lang('league_header_table_goals_diff');?></div>
                                    <div class="td"><?php echo lang('league_header_table_points');?></div>
                                </div>
                                <?php foreach($getlastable as $showtable): ?>
                                <div class="tr">
                                    <div class="td"><div><?php echo $showtable->position;?></div></div>
                                    <div class="td"><img class="team-logo-table-30" src="<?= base_url().'assets/img/teams_logo/'.$showtable->logo;?>"><div class="team-name-table"><span class="full-text"><?php echo $showtable->team;?></span><span class="truncate-box-text"><?php echo substr($showtable->team, 0, 3);?></span></div></div>
                                    <div class="td"><?php echo $showtable->P;?></div>
                                    <div class="td sm-hide"><?php echo $showtable->W;?></div>
                                    <div class="td sm-hide"><?php echo $showtable->D;?></div>
                                    <div class="td sm-hide"><?php echo $showtable->L;?></div>
                                    <div class="td"><?php echo $showtable->F;?></div>
                                    <div class="td"><?php echo $showtable->A;?></div>
                                    <div class="td"><?php echo $showtable->GD;?></div>
                                    <div class="td"><?php echo $showtable->Pts;?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>    
</div>

