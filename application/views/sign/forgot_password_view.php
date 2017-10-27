<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="theme-color" content="#e84e40">
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
                    <a href="javascript:void(0);"></a>
                    <span><?php echo lang('rpsw_logo_description');?></span>
                </div>
                <div class="panel">
                    <form action="<?php echo site_url("sign/forgot_password/doforget");?>" method="post" role="form" name="resetpswForm" id="resetpswForm" autocomplete="off" novalidate="novalidate" class="fv-form fv-form-bootstrap">
                        <div class="panel-body"> 
                            <div class="form-message"><?php echo lang('rpsw_auth_title');?></div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">email</i></span>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="<?php echo lang('rpsw_inputmail_placeholder');?>" required>                        
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger btn-block btn-raised" id="btnResetPswForm"><span><?php echo lang('rpsw_button_reset');?></span></button>
                            </div>
                            <p class="auth-link"><?php echo lang('rpsw_desc_link_signin');?> <a class="animsition-link" href="<?= base_url();?>sign/signin"><strong><?php echo lang('rpsw_link_signin');?></strong></a></p>
                        </div>
                    </form>    
                </div>
            </div>
        </div>
        <script>           
            var cklocal = '<?php echo lang('form_validation_message_language');?>';           
        </script>
        <?php $this->load->view('common/varlanguage'); ?>
        <?php echo put_footer()?>    
    </body>
</html>

