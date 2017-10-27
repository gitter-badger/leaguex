/*
LEAGUEX
@copyright (C) 2014 fankstribe. All rights reserved.
@license http://www.gnu.org/copyleft/gpl.html GNU/GPL
License: Open source - MIT
@link http://www.fankstribe.org 
*/

/* Login form validation */
function loginFormValidation(){ 
    if ($('#loginForm').length && $.fn.formValidation) {
        $('#loginForm').formValidation({   
            framework: "bootstrap",
            excluded: ':disabled',
            locale: cklocal,
            fields: {
                email: {           
                    validators: {            
                        notEmpty: {}                   
                    }
                },       
                password: {
                    validators: {
                        notEmpty: {}           
                    }
                }        
            }   
        })
        .on('err.field.fv', function(e, data) {
            data.fv.disableSubmitButtons(false);
            
        }) 
        .on('success.form.fv',function(e){
            $('.panel-body').waitMe({
            effect: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#f44336'
            });
            e.preventDefault();    
            var $form = $(e.target),
            fv    = $form.data('formValidation');
            fv.disableSubmitButtons(false);
            setTimeout(function(){
                $.ajax({
                    url:$form.attr('action'),
                    type: 'POST',                    
                    data: $form.serialize(),
                    success:function(result){                        
                        if(result.ban){
                            $('.panel-body').waitMe("hide"); 
                            $.notify({message: logErrorBan});
                            fv.disableSubmitButtons(false);
                        }
                        else if(result.error){
                            $('.panel-body').waitMe("hide"); 
                            $.notify({message: logErrorUser});
                            fv.disableSubmitButtons(false);
                        }                       
                        else{
                        window.location.href="../home";                            
                        }                    
                    }                    
                });
                
            },   600);  
        }); 
    }    
}

/* Register form validation */
function registerFormValidation(){    
    if ($('#registerForm').length && $.fn.formValidation) {
        $('.format').focus(function() {
        $(this).attr('placeholder', '__/__/____')}).blur(function() {
            $(this).attr('placeholder', ckdate)
        });
        $('#registerForm').formValidation({   
            framework: "bootstrap", 
            excluded: ':disabled',
            live: 'submitted',
            locale: cklocal,       
            fields: {
                username: {           
                    validators: {
                        remote: {
                            message: ckusername,
                            url: 'signup/check_username',
                            type: 'POST'                        
                        },  
                        notEmpty: {},
                        stringLength: {                
                            min:4,
                            max:30
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/
                        }           
                    }
                },
                email: {
                    validators: {
                        remote: {
                            message: ckemail,
                            url: 'signup/check_email',
                            type: 'POST'
                        },    
                        notEmpty: {},
                        emailAddress: {},
                        regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$'                           
                        }
                    }
                },
                birthday: {
                    validators: {
                        notEmpty: {},
                        date: {
                        format: 'DD/MM/YYYY'                        
                    }               
                    }
                },
                password: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 4,
                            max:20
                        }
                    }
                },
                confirmPassword: {
                    validators: {            
                        identical: {
                            field: 'password'                
                        },
                        notEmpty: {}
                    }
                }           
            }   
        })  
        .find('[name="birthday"]').mask('00/00/0000').end() 
        .on('err.field.fv', function(e, data) {
        data.fv.disableSubmitButtons(false);
            
        }) 
        .on('success.field.fv', function(e, data) {
        data.fv.disableSubmitButtons(false);
        })
        .on('err.validator.fv', function(e, data) {
            data.fv.disableSubmitButtons(false);
            if((data.field === 'email')||(data.field === 'password')||(data.field === 'confirmPassword')||(data.field === 'birthday')||(data.field === 'username')) {
                data.element
                .data('fv.messages')
                .find('.help-block[data-fv-for="' + data.field + '"]').hide()
                .filter('[data-fv-validator="' + data.validator + '"]').show();
            }
        }) 
        .off('success.form.fv')
        .on('success.form.fv',function(e){
            $('.panel-body').waitMe({
                effect: '',
                bg: 'rgba(255,255,255,0.7)',
                color: '#f44336'
            });
            e.preventDefault();  
            var $form = $(e.target),
            fv = $form.data('formValidation');
            fv.disableSubmitButtons(false);
            setTimeout(function(){
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success:function(result){
                        if(result !==''){
                            $('.panel-body').waitMe("hide"); 
                        }else{
                            $('.panel-body').waitMe("hide"); 
                            $form.formValidation('resetForm', true);
                            fv.disableSubmitButtons(false);
                            $.notify({message: regSuccess, url: 'signin'});
                        }                
                    }
                });
            }, 600);         
        });    
    }
}

/* Reset password form validation */
function resetPasswordFormValidation(){
    if ($('#resetpswForm').length && $.fn.formValidation) {
        $('#resetpswForm').formValidation({   
            framework: "bootstrap",   
            locale: cklocal,
            fields: {
                email: {           
                    validators: {            
                    notEmpty: {}                   
                    }
                }   
            }   
        })
        .on('err.validator.fv', function(e, data) {
            data.fv.disableSubmitButtons(false);
        })
        .on('success.form.fv',function(e){
        $('.panel-body').waitMe({
            effect: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#f44336'
        });    
        e.preventDefault();    
        var $form = $(e.target),
            fv    = $form.data('formValidation'); 
            fv.disableSubmitButtons(false);
            setTimeout(function(){
                $.ajax({
                    url:$form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success:function(result){
                        if(result !==''){ 
                            $('.panel-body').waitMe("hide"); 
                            fv.disableSubmitButtons(false);
                            $.notify({message: rpswErrorMailreset});
                            $form.formValidation('resetForm', true);
                            }else{
                            $('.panel-body').waitMe("hide"); 
                            fv.disableSubmitButtons(false); 
                            $.notify({message: rpswSuccessMailreset});
                            $form.formValidation('resetForm', true);
                        }                
                    }
                });
            },   600);  
        }); 
    }    
}

/* Edit settings - User account */
function editUserAccount(){
    if($('#editUserAccountForm').length && $.fn.formValidation) {
        $('.format').focus(function() {
        $(this).attr('placeholder', '__/__/____')}).blur(function() {
            $(this).attr('placeholder', '');
        });
        $('#editUserAccountForm').formValidation({   
            framework: "bootstrap", 
            live: 'submitted',
            locale: cklocal,
            fields: {
                email: {
                    validators: {
                        remote: {
                            message: ckemail,
                            url: base+ 'users/edit_settings/check_email',
                            type: 'POST'
                        },    
                        notEmpty: {},
                        emailAddress: {},
                        regexp: {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$'                           
                        }
                    }
                },
                newpassword: {
                    enabled: false,
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 4,
                            max: 20
                        }
                    }
                },
                confirmpassword: {
                    enabled: false,
                    validators: {            
                        identical: {
                            field: 'newpassword'                
                        },
                        notEmpty: {}
                    }
                },        
                birthday: {
                    validators: {
                        notEmpty: {},
                        date: {
                            format: 'DD/MM/YYYY'                        
                        }
                    }
                }            
            }
        })
        .find('[name="birthday"]').mask('00/00/0000').end()
        .on('keyup', '[name="newpassword"]', function(){
            var isEmpty = $(this).val() === '';
            $('#editUserAccountForm').formValidation('enableFieldValidators', 'newpassword', !isEmpty);
            $('#editUserAccountForm').formValidation('enableFieldValidators', 'confirmpassword', !isEmpty);
            if($(this).val().length === 1){
                $('#editUserAccountForm').formValidation('validateField', 'newpassword');
                $('#editUserAccountForm').formValidation('validateField', 'confirmpassword');
            }    
        })
        .on('err.validator.fv', function(e, data) {
            if ((data.field === 'username')||(data.field === 'email')||(data.field === 'birthday')||(data.field === 'newpassword')||(data.field === 'confirmpassword')) {
                data.element
                .data('fv.messages')
                .find('.help-block[data-fv-for="' + data.field + '"]').hide()
                .filter('[data-fv-validator="' + data.validator + '"]').show();
            }           
        })
        .off('success.form.fv')
        .on('success.form.fv',function(e){
            $('.modal-content').waitMe({
                effect: '',
                bg: 'rgba(255,255,255,0.7)',
                color: '#f44336'
            });
            e.preventDefault();
            var $form = $(e.target),
            fv = $form.data('formValidation');
            setTimeout(function(){
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        $('.modal-content').waitMe("hide");
                        fv.disableSubmitButtons(false);
                        if(response.success){
                            updateaccount = response.editaccount;
                            var email = $('#emailAccount');
                            var birthday = $('#birthdayAccount');
                            var city = $('#cityAccount');
                            var date = moment(updateaccount.userbirthday).format('DD/MM/YYYY');
                            email.html(updateaccount.useremail);
                            city.html(updateaccount.usercity);
                            birthday.html(date);
                        }
                        $form.parents('.bootbox').modal('hide');
                        $('.panel .useraccount .list-desc').effect('highlight', {color: "#e8f0fe"}, 3000);
                        $.notify({message: updateSuccessMessage});
                    }
                });
            }, 600); 
        });
    }
    
    $('#editAccount').on('click', function(){
        var userid = $(this).attr('data-id');
        $('#editInputPassword').val('');
        $('#editInputConfirmPassword').val('');
        $.ajax({
            url: base +'users/edit_settings/get_user_account',
            type: 'POST',
            data: 'userid=' + userid, 
            success: function(response){
                if(response.success){
                    edatauser = response.datauser;
                    var birthday = moment(edatauser.userbirthday).format('DD/MM/YYYY');
                    $('#editUserAccountForm').find('#editUserId').val(edatauser.userid);
                    $('#editInputEmail').val(edatauser.useremail);
                    $('#hiddenPassword').val(edatauser.userpassword);
                    $('#editInputBirthday').val(birthday);
                    $('#editInputCity').val(edatauser.usercity);
                }    
            }    
        });
        bootbox.dialog({
            message: $('#editUserAccountForm'),
            className: 'bootbox-form',
            show: false,
            closeButton: false
        }).on('shown.bs.modal', function(){
            if($(window).width() < 750) {
                $('.modal .modal-body-custom').css('overflow-y', 'auto'); 
                $('.modal .modal-body-custom').css('max-height', $(window).height() - 66);
                $('.modal .modal-body-custom').css('height', $(window).height() - 66);
            }
            $(window).on('resize', function() {
            if($(window).width() < 750) {
                $('.modal .modal-body-custom').css('overflow-y', 'auto'); 
                $('.modal .modal-body-custom').css('max-height', $(window).height() - 66);
                $('.modal .modal-body-custom').css('height', $(window).height() - 66);
            }
            });
            $('#editUserAccountForm').show().formValidation('resetForm');
        }).on('hide.bs.modal', function(e){
            $('#editUserAccountForm').hide().formValidation('resetForm').appendTo('body');
        }).modal('show');
    
    });
}

/* Edit settings - User info */
function editUserInfo(){
    if($('#editUserInfoForm').length && $.fn.formValidation) {
        $('#editUserInfoForm').formValidation({   
            framework: "bootstrap", 
            live: 'submitted',
            locale: cklocal,
            fields: {
                aboutme: {
                    enabled: false,
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 4,
                            max: 150
                        }
                    }
                } 
            }
        })
        .on('keyup', '[name="aboutme"]', function(){
            var isEmpty = $(this).val() === '';
            $('#editUserInfoForm').formValidation('enableFieldValidators', 'aboutme', !isEmpty);
            if($(this).val().length === 1){
                $('#editUserInfoForm').formValidation('validateField', 'aboutme');
            }    
        })
        .off('success.form.fv')
        .on('success.form.fv',function(e){
            $('.modal-content').waitMe({
                effect: '',
                bg: 'rgba(255,255,255,0.7)',
                color: '#f44336'
            });
            e.preventDefault();
            var $form = $(e.target),
            fv = $form.data('formValidation');
            setTimeout(function(){
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        $('.modal-content').waitMe("hide");
                        fv.disableSubmitButtons(false);
                        if(response.success){
                            updateinfo = response.editinfo;
                            var skype = $('#skypeInfo');
                            var xbox = $('#xboxInfo');
                            var psn = $('#psnInfo');
                            var favoriteclub = $('#favoriteClubInfo');
                            var aboutme = $('#profile-page').find('.user-profile-about');
                            skype.html(updateinfo.skype);
                            xbox.html(updateinfo.xbox);
                            psn.html(updateinfo.psn);
                            favoriteclub.html(updateinfo.favoriteclub);
                            aboutme.html(updateinfo.aboutme);
                        }
                        $form.parents('.bootbox').modal('hide');
                        $('.panel .userinfo .list-desc, .user-profile-about').effect('highlight', {color: "#e8f0fe"}, 3000);
                        $.notify({message: updateSuccessMessage});
                    }
                });
            }, 600); 
        });
    }
    
    $('#editInfo').on('click', function(){
        var userid = $(this).attr('data-id');
        $('#editUserInfoForm').find('.empty').removeClass('is-empty');
        $.ajax({
            url: base +'users/edit_settings/get_user_info',
            type: 'POST',
            data: 'userid=' + userid, 
            success: function(response){
                if(response.success){
                    edatauser = response.datauser;
                    $('#editUserInfoForm').find('#editUserId').val(edatauser.userid);
                    $('#editInputSkype').val(edatauser.userskype);
                    $('#editInputXbox').val(edatauser.userxbox);
                    $('#editInputPsn').val(edatauser.userpsn);
                    $('#editInputfavoriteclub').val(edatauser.userfavoriteclub);
                    $('#editInputAboutMe').val(edatauser.aboutme);
                }    
            }    
        });
        bootbox.dialog({
            message: $('#editUserInfoForm'),
            className: 'bootbox-form',
            show: false,
            closeButton: false
        }).on('shown.bs.modal', function(){
            if($(window).width() < 750) {
                $('.modal .modal-body-custom').css('overflow-y', 'auto'); 
                $('.modal .modal-body-custom').css('max-height', $(window).height() - 66);
                $('.modal .modal-body-custom').css('height', $(window).height() - 66);
            }
            $(window).on('resize', function() {
            if($(window).width() < 750) {
                $('.modal .modal-body-custom').css('overflow-y', 'auto'); 
                $('.modal .modal-body-custom').css('max-height', $(window).height() - 66);
                $('.modal .modal-body-custom').css('height', $(window).height() - 66);
            }
            });
            $('#editUserInfoForm').show().formValidation('resetForm');
        }).on('hide.bs.modal', function(e){
            $('#editUserInfoForm').hide().formValidation('resetForm').appendTo('body');
        }).modal('show');
    
    });
}

/****  Init functions  ****/
$(document).ready(function () { 
loginFormValidation();    
registerFormValidation();
resetPasswordFormValidation();
editUserAccount();
editUserInfo();
});


