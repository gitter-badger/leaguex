<section id="main-wrapper">
    <div class="container-fluid">
        <div class="custom-header custom-header-block">
            <div class="custom-header-content">
                 <h4 class="page-title"><?php echo lang('admin_ulist_header_title');?></h4>
            </div>
            <div class="custom-header-content">
                <div class="container-breadcrumb">
                    <ol class="breadcrumb no-margin">
                        <li><a class="animsition-link" href="<?= base_url().'admin/home';?>">Home</a></li>
                        <li><?php echo lang('admin_ulist_header_title');?></li>
                    </ol>
                </div>
            </div>        
        </div> 
        <div class="row animsition">            
            <div class="col-lg-12">                      
                <div class="panel">                    
                    <div class="panel-body">
                        <div class="add-button">
                            <button class="btn btn-info" id="addUser"><?php echo lang('table_header_add_button');?></button>                                    
                        </div>
                        <?php $this->load->view('admin/modals/new_user_form');?>
                        <?php $this->load->view('admin/modals/edit_user_form');?>
                        <input type="hidden" name="getdetails" value="<?php echo $option->table_details;?>">
                        <table class="table dataTable width-full responsive nowrap" id="userList">
                            <thead>
                                <tr>
                                    <th style="visibility:hidden"></th>
                                    <th><?php echo lang('admin_ulist_header_table_user');?></th>
                                    <th><?php echo lang('admin_ulist_header_table_email');?></th>
                                    <th><?php echo lang('admin_ulist_header_table_permission');?></th>
                                    <th><?php echo lang('table_header_creation_date');?></th>
                                    <th><?php echo lang('admin_ulist_header_last_activity');?></th>
                                    <th><?php echo lang('table_header_action');?></th>
                                   
                                </tr>
                            </thead>                               
                            <tbody></tbody>
                        </table>                        
                    </div>
                </div>
            </div>    
        </div>
    </div>    
</section> 