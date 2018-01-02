<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">        
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,minimal-ui">
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
    <body id="auth-pages">
        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="wrap">
            <div class="auth-form animsition" data-animsition-in-class="fade-in" data-animsition-out-class="fade-out">                           
                <div class="logo">
                    <a class="img-logo" href="javascript:void(0);"></a>
                    <span><?php echo lang('log_logo_description');?></span>
                </div>
                <div class="panel">
                    <form action="<?php echo site_url("sign/signin/login");?>" method="post" role="form" name="loginForm" id="loginForm" autocomplete="off" novalidate="novalidate" class="fv-form fv-form-bootstrap">
                        <div class="panel-body">
                            <div class="form-message"><?php echo lang('log_auth_title');?></div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">email</i></span>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">  
                                </div>
                            </div>                   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">lock</i></span>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">                        
                                </div>
                            </div>                                                                        
                            <div class="form-group">
                                <div class="checkbox">                                
                                    <label for="rememberme">
                                        <input type="checkbox" id="rememberme" name="rememberme">
                                          <?php echo lang('log_checkbox_rememberme');?>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mt-0">
                                <button type="submit" class="btn btn-danger btn-block btn-raised" id="btnLoginForm"><span><?php echo lang('log_button_signin');?></span></button>                                                
                                <p class="auth-link"><a class="animsition-link" id="forgot-psw" href="<?php echo site_url("sign/forgot_password");?>"><?php echo lang('log_link_forgotpassword');?></a></p>
                                <p class="auth-link pad-t-0"><?php echo lang('log_desc_link_signup');?> <a class="animsition-link" href="<?= base_url();?>sign/signup"><?php echo lang('log_link_signup');?></a></p> 
                            </div>
                        </div>
                    </form>    
                </div>
            </div>  
        </div>    
        <script>           
            var cklocal = '<?php echo lang('form_validation_message_language');?>';
            var base = '<?php echo base_url();?>';
        </script>
        <?php $this->load->view('common/varlanguage'); ?>
        <?php echo put_footer()?>
        <script>
            $(function() { 
                if (localStorage.chkbx && localStorage.chkbx != '') {
                    $('#rememberme').attr('checked', 'checked');
                    $('#email').val(localStorage.usrname);
                    $('#password').val(localStorage.pass);
                } else {
                    $('#rememberme').removeAttr('checked');
                    $('#email').val('');
                    $('#password').val('');
                } 
                $('#rememberme').click(function() { 
                    if ($('#rememberme').is(':checked')) {
                        // save username and password
                        localStorage.usrname = $('#email').val();
                        localStorage.pass = $('#password').val();
                        localStorage.chkbx = $('#rememberme').val();
                    } else {
                        localStorage.usrname = '';
                        localStorage.pass = '';
                        localStorage.chkbx = '';
                    }
                });
            });
 
        </script>
    </body>
</html>

