<section id="main-wrapper">
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                <h4 class="page-title"><?php echo lang('admin_plist_header_title');?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><?php echo lang('admin_plist_header_title');?></li>
                    </ol>
                </div>
            </div>     
        </div>
        <div class="row animsition">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-body">                       
                        <table class="table dataTable table-striped width-full responsive" id="playersList">
                            <thead>
                                <tr>
                                    <th style="visibility:hidden"></th>
                                    <th><?php echo lang('admin_plist_header_table_name');?></th>
                                     <th><?php echo lang('admin_plist_header_table_team');?></th>
                                    <th><?php echo lang('admin_plist_header_table_overall');?></th>                                   
                                    <th><?php echo lang('admin_plist_header_table_position');?></th>
                                    <th><?php echo lang('admin_plist_header_table_age');?></th>
                                    <th><?php echo lang('table_header_action');?></th>                                    
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th style="visibility:hidden"></th>
                                    <th><?php echo lang('admin_plist_header_table_name');?></th>
                                    <th><?php echo lang('admin_plist_header_table_overall');?></th>                                   
                                    <th><?php echo lang('admin_plist_header_table_position');?></th>
                                    <th><?php echo lang('admin_plist_header_table_age');?></th>
                                    <th><?php echo lang('table_header_action');?></th>
                                    <th style="visibility:hidden"></th>
                                    <th style="visibility:hidden"></th>
                                    <th style="visibility:hidden"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>  
            </div> 
        </div>   
    </div>
</section>
