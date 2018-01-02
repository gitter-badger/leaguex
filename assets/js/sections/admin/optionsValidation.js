/*!
*   LEAGUEX
*   @copyright (C) 2014 fankstribe. All rights reserved.
*   @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*   License: Open source - MIT
*   @link http://www.fankstribe.org 
!*/

/* Media form validation */
function mediaFormValidation(){
     if($('#updateMediaOptions').length && $.fn.formValidation) {                    
        $('#updateMediaOptions').formValidation({   
            framework: "bootstrap", 
            live: 'submitted',
            locale: cklocal,            
            fields: {
                avatarSizeMax: {                    
                    excluded: false,                    
                    validators: {
                        numeric: {},
                        notEmpty: {}                        
                    }
                },
                avatarSizeMin: {                    
                    excluded: false,                   
                    validators: {
                        numeric: {},
                        notEmpty: {}                        
                    }
                },
                logoSizeMax: { 
                    excluded: false,
                    validators: {                       
                        numeric: {},
                        notEmpty: {}
                    }
                },
                logoSizeMin: { 
                    excluded: false,
                    validators: {                       
                        numeric: {},
                        notEmpty: {}
                    }
                }
            }        
    })
    .on('keyup', 'input[name="avatarMaxWidth"], input[name="avatarMaxHeight"]', function(e){        
        var avatarmaxwidth = $('#updateMediaOptions').find('[name="avatarMaxWidth"]').val(),
            avatarmaxheight = $('#updateMediaOptions').find('[name="avatarMaxHeight"]').val();
        $('#updateMediaOptions').find('[name="avatarSizeMax"]').val(avatarmaxwidth === '' || avatarmaxheight === '' ? '' : [avatarmaxwidth,avatarmaxheight].join('.'));
        $('#updateMediaOptions').formValidation('revalidateField', 'avatarSizeMax');                
    })
    .on('keyup', 'input[name="avatarMinWidth"], input[name="avatarMinHeight"]', function(e){
        var avatarminwidth = $('#updateMediaOptions').find('[name="avatarMinWidth"]').val(),
            avatarminheight = $('#updateMediaOptions').find('[name="avatarMinHeight"]').val();
        $('#updateMediaOptions').find('[name="avatarSizeMin"]').val(avatarminwidth === '' || avatarminheight === '' ? '' : [avatarminwidth,avatarminheight].join('.'));
        $('#updateMediaOptions').formValidation('revalidateField', 'avatarSizeMin');        
    })
    .on('keyup', 'input[name="logoMaxWidth"], input[name="logoMaxHeight"]', function(e){
        var logomaxwidth = $('#updateMediaOptions').find('[name="logoMaxWidth"]').val(),
            logomaxheight = $('#updateMediaOptions').find('[name="logoMaxHeight"]').val();
        $('#updateMediaOptions').find('[name="logoSizeMax"]').val(logomaxwidth === '' || logomaxheight === '' ? '' : [logomaxwidth,logomaxheight].join('.'));
        $('#updateMediaOptions').formValidation('revalidateField', 'logoSizeMax');        
    })
    .on('keyup', 'input[name="logoMinWidth"], input[name="logoMinHeight"]', function(e){
        var logominwidth = $('#updateMediaOptions').find('[name="logoMinWidth"]').val(),
            logominheight = $('#updateMediaOptions').find('[name="logoMinHeight"]').val();
        $('#updateMediaOptions').find('[name="logoSizeMin"]').val(logominwidth === '' || logominheight === '' ? '' : [logominwidth,logominheight].join('.'));
         $('#updateMediaOptions').formValidation('revalidateField', 'logoSizeMin');        
    })   
    .on('success.form.fv',function(e){
        $('.panel').waitMe({
            effect: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#f44336'
        });
        e.preventDefault();        
        var $form = $(e.target),
        fv    = $form.data('formValidation');           
        setTimeout(function(){
            $.ajax({
                url:$form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success:function(result){
                    if(result ==''){
                        $('.panel').waitMe("hide"); 
                        fv.disableSubmitButtons(false);
                        $.notify({message: updateSuccessMessage});                     
                    }        
                }
            });
        }, 600); 
    });
    }
}

/* General form validation */
function generalFormValidation(){
     if($('#updateGeneralOptions').length && $.fn.formValidation) {                    
        $('#updateGeneralOptions').formValidation({   
            framework: "bootstrap",
            live: 'submitted',
            locale: cklocal,            
            fields: {
                language: { 
                    validators: {                        
                        notEmpty: {}                      
                    }
                },
                sitename: { 
                    validators: {                        
                        notEmpty: {}                      
                    }
                },
                sitetitle: { 
                    validators: {                        
                        notEmpty: {}                      
                    }
                }
            }        
    })    
    .on('success.form.fv',function(e){
        $('.panel').waitMe({
            effect: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#f44336'
        });
        e.preventDefault();        
        var $form = $(e.target),
        fv    = $form.data('formValidation');           
        setTimeout(function(){
            $.ajax({
                url:$form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success:function(result){
                    if(result ==''){
                        $('.panel').waitMe("hide"); 
                        fv.disableSubmitButtons(false);
                        $.notify({message: updateSuccessMessage});
                    }   
                }
            });
        }, 600); 
    });
    }
}

/* Players levels form validation */
function levelsFormValidation(){
    if($('#players-levels').is(':checked')){
           $('input#ova').attr('disabled', false);
       } 
       else if($(this).not(':checked')){
           $('input#ova').attr('disabled', true);
       }
    $('input:radio').click(function(){
        if($(this).val() == 1){
            $('input#ova').attr('disabled', false);
    }
        else if($(this).val() == 0){
            $('input#ova').attr('disabled', true);
    }
    });
    if($('#updateLevelsOptions').length && $.fn.formValidation) {
        $('#updateLevelsOptions').formValidation({   
            framework: "bootstrap",  
            live: 'submitted',
            locale: cklocal,            
            fields: {
               'levMin[]':{
                    validators: {
                        notEmpty: {},
                        integer:{},
                    }
                },
                'levMax[]':{
                    validators: {
                        notEmpty: {},
                        integer:{},
                    }
                },
                'maxPlayers[]':{
                    validators: {
                        notEmpty: {},
                        integer:{}
                    }
                } 
            }        
    }) 
   .on('click', '.addButton', function() {
        if($('#players-levels').is(':checked')){
            var $template = $('#optionTemplate'),
            $clone = $template.clone().removeClass('hide').removeAttr('id').insertBefore($template);
            $('#updateLevelsOptions')
                .formValidation('addField', $clone.find('[name="levMin[]"]'))
                .formValidation('addField', $clone.find('[name="levMax[]"]'))
                .formValidation('addField', $clone.find('[name="maxPlayers[]"]'));
        }
    })
    .on('click', '.removeButton', function(){
        if($('#players-levels').is(':checked')){
            var $row = $(this).closest('.form-group');
            $('#updateLevelsOptions')
                .formValidation('removeField', $row.find('[name="levMin[]"]'))
                .formValidation('removeField', $row.find('[name="levMax[]"]'))
                .formValidation('removeField', $row.find('[name="maxPlayers[]"]'));
            $row.remove();
        }
    })
    .on('added.field.fv', function(e, data) {
        if (data.field === 'levMin[]') {
            if ($('#updateLevelsOptions').find(':visible[name="levMin[]"]').length >= 10) {
                $('#updateLevelsOptions').find('.addButton').attr('disabled', 'disabled');
            }
        }
    })
    .on('removed.field.fv', function(e, data) {
        if (data.field === 'levMin[]') {
            if ($('#updateLevelsOptions').find(':visible[name="levMin[]"]').length < 10) {
                $('#updateLevelsOptions').find('.addButton').removeAttr('disabled');
            }
        }
    })
    .on('err.field.fv', function(e, data) {
        data.element
            .data('fv.messages')
            .find('.help-block[data-fv-for="' + data.field + '"]').hide();
    })
    
    .on('success.form.fv',function(e){
        $('.panel').waitMe({
            effect: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#f44336'
        });
        e.preventDefault();        
        var $form = $(e.target),
        fv    = $form.data('formValidation');           
        setTimeout(function(){
            $.ajax({
                url:$form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success:function(result){
                    if(result ==''){
                        $('.panel').waitMe("hide"); 
                        fv.disableSubmitButtons(false);
                        $.notify({message: updateSuccessMessage});                      
                    }   
                }
            });
        }, 600); 
    });
    }
}

/* Players form validation */
function playersFormValidation(){
    if($('#updatePlayersOptions').length && $.fn.formValidation) {                    
        $('#updatePlayersOptions').formValidation({   
            framework: "bootstrap",  
            live: 'submitted',
            locale: cklocal,            
            fields: {
                urlStats: { 
                    validators: {                        
                        notEmpty: {},
                        uri:{}
                    }
                },
                urlImage: { 
                    validators: {                        
                        notEmpty: {},
                        uri:{}
                    }
                }
            }        
    })   
    .on('success.form.fv',function(e){ 
        $('.panel').waitMe({
            effect: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#f44336'
        });
        e.preventDefault();        
        var $form = $(e.target),
        fv    = $form.data('formValidation');           
        setTimeout(function(){
            $.ajax({
                url:$form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success:function(result){
                    if(result ==''){
                        $('.panel').waitMe("hide"); 
                        fv.disableSubmitButtons(false);
                        $.notify({message: updateSuccessMessage});                       
                    }   
                }
            });
        }, 600); 
    });
    }
}

/* Email form validation */
function emailFormValidation(){
    if($('#updateEmailOptions').length && $.fn.formValidation) {                    
        $('#updateEmailOptions').formValidation({   
            framework: "bootstrap",
            live: 'submitted',
            locale: cklocal,            
            fields: {
                email: { 
                    validators: {                                               
                        emailAddress: {}
                    }
                },                
                port: {
                    validators:{
                        integer: {
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        }                
                    }
                }
            }        
    })    
    .on('success.form.fv',function(e){
        $('.panel').waitMe({
            effect: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#f44336'
        });
        e.preventDefault();        
        var $form = $(e.target),
        fv    = $form.data('formValidation');           
        setTimeout(function(){
            $.ajax({
                url:$form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success:function(result){
                    if(result ==''){ 
                        $('.panel').waitMe("hide"); 
                        fv.disableSubmitButtons(false);
                        $.notify({message: updateSuccessMessage});
                    }   
                }
            });
        }, 600); 
    });
    }
}

/* Test SMTP form validation */
function testFormValidation(){
    if($('#testEmailOptions').length && $.fn.formValidation) {                    
        $('#testEmailOptions').formValidation({   
            framework: "bootstrap", 
            live: 'submitted',
            locale: cklocal,            
            fields: {
                testemail: { 
                    validators: {                                               
                        emailAddress: {},
                        notEmpty: {}
                    }
                }                
            }        
    })    
    .on('success.form.fv',function(e){
        $('.panel').waitMe({
            effect: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#f44336'
        });
        e.preventDefault();        
        var $form = $(e.target),
        fv    = $form.data('formValidation');           
        setTimeout(function(){
            $.ajax({
                url:$form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success:function(result){
                    if(result ==''){
                        $('.panel').waitMe("hide"); 
                        fv.disableSubmitButtons(false);
                        $form.formValidation('resetForm', true);
                        $.notify({message: successSMTPmessage});
                    } else {
                        $('.container-fluid').waitMe("hide"); 
                        fv.disableSubmitButtons(false);
                        $form.formValidation('resetForm', true);
                        $.notify({message: errorSMTPmessage});
                    }   
                }
            });
        }, 600); 
    });
    }
}

/* Events form validation */

function eventsFormValidation(){
    if($('#updateEventsOptions').length && $.fn.formValidation){
        $('#updateEventsOptions').formValidation({
            framework: "bootstrap", 
            live: 'submitted',
            locale: cklocal,            
            fields: {
                'eventName[]': {                    
                    validators: {
                        notEmpty: {}                        
                    }
                },
                'eventImage[]': {
                    enabled: false,
                    validators: {
                        notEmpty: {}                        
                    }
                }
            }
        })
        .on('click', '.addButton', function(){
            
            var num = $('.form-group .input-group:visible').length;
            var newNum = new Number(num + 1);
            var $template = $('#optionTemplate'),
            $clone = $template.clone().removeClass('hide').removeAttr('id').insertBefore($template);
            $clone.find('.input-group').addClass('input-file');   
            $clone.find('#eventName').attr('name','eventName[]');
            $clone.find('#inputFile').attr('name','eventImage[]');
            $clone.find('.uploadFile').attr('id','uploadFile_'+ newNum);
            $clone.find('.uploadFile').attr('onMouseOver','fileUpload('+newNum+')');
            $clone.find('#eventName').addClass('icon-clear');
            cleareInputValue();
            $('#updateEventsOptions')
                .formValidation('addField', $clone.find('[name="eventName[]"]'))
                .formValidation('addField', $clone.find('[name="eventImage[]"]'));;
           
        })
        .on('click', '.removeButton', function(){
            var $row = $(this).closest('.form-group');
            $row.remove();
            $('#updateEventsOptions')
                .formValidation('removeField', $row.find('[name="eventName[]"]'))
                .formValidation('removeField', $row.find('[name="eventImage[]"]'));
              
                
        })
        .on('success.form.fv',function(e){
        $('.panel').waitMe({
            effect: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#f44336'
        });
        e.preventDefault();        
        var $form = $(e.target),
        fv    = $form.data('formValidation');           
        setTimeout(function(){
            $.ajax({
                url:$form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success:function(result){
                    if(result ==''){
                        $('.panel').waitMe("hide"); 
                        fv.disableSubmitButtons(false);
                        $.notify({message: updateSuccessMessage});                      
                    }   
                }
            });
        }, 600); 
    });
    }   
}

/* Init Functions */
$(document).ready(function () {    
    mediaFormValidation();
    generalFormValidation();
    levelsFormValidation();
    playersFormValidation();
    emailFormValidation();
    testFormValidation();
    eventsFormValidation();
});


