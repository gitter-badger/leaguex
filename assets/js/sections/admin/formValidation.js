/*!
*   LEAGUEX
*   @copyright (C) 2014 fankstribe. All rights reserved.
*   @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*   License: Open source - MIT
*   @link http://www.fankstribe.org 
!*/

/****  Edit user form validation  ****/

//Change password form
function pswFormValidation(){
    if ($('#updatePassword').length && $.fn.formValidation) {
        $('#updatePassword').formValidation({   
            framework: "bootstrap", 
            live: 'submitted',
            locale: cklocal,
            fields: {            
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
    .on('err.validator.fv', function(e, data) {
        if ((data.field === 'password')||(data.field === 'confirmPassword')) {
            data.element
            .data('fv.messages')
            .find('.help-block[data-fv-for="' + data.field + '"]').hide()
            .filter('[data-fv-validator="' + data.validator + '"]').show();
        }
    })
    .on('success.form.fv',function(e){
        $('.container-fluid').waitMe({
            effect: 'rotation',
            bg: 'rgba(255,255,255,0.7)',
            color: '#f44336'
        });
        e.preventDefault();    
        var $form = $(e.target),
        fv = $form.data('formValidation');           
        setTimeout(function(){
            $.ajax({
                url:$form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success:function(result){
                    if(result ==''){
                        $('.container-fluid').waitMe("hide"); 
                        fv.disableSubmitButtons(false);
                        $form.formValidation('resetForm', true);
                        $.notify({message: updateSuccessMessage});                     
                    }                        
                }
            });
        }, 600); 
    });
    }
}
/****  End edit user form validation  ****/



/****  Edit manager form validation  ****/

function managerFormValidation(){   
    if($('#updateManager').length && $.fn.formValidation) {            
        $('#updateManager').find('[name="teamname"]').selectpicker().change(function(e) {                
                $('#updateManager').formValidation('revalidateField', 'teamname');
            })
            .end();
            $('#updateManager').formValidation({   
            framework: "bootstrap", 
            live: 'submitted',
            locale: cklocal,
            excluded: ':disabled',
            fields: {
                managerwallet: {           
                    validators: {                        
                        notEmpty: {}
                    }
                }       
            }        
    })
    .on('err.validator.fv', function(e, data) {
        if ((data.field === 'teamname')||(data.field === 'managerwallet')) {
            data.element
            .data('fv.messages')
            .find('.help-block[data-fv-for="' + data.field + '"]').hide()
            .filter('[data-fv-validator="' + data.validator + '"]').show();
            }
        })
    .on('success.form.fv',function(e){ 
        $('.container-fluid').waitMe({
            effect: 'rotation',
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
                        $('.container-fluid').waitMe("hide"); 
                        fv.disableSubmitButtons(false);
                        $.notify({message: updateSuccessMessage});                         
                    }       
                }
            });
        },   600);  
    });
    }
}
/****  End edit manager form validation  ****/

/****  Edit player form validation  ****/

function playerFormValidation(){    
    if($('#updatePlayer').length && $.fn.formValidation) {
        $('#updatePlayer').formValidation({   
            framework: "bootstrap",       
            locale: cklocal,            
            fields: {
                age: {                    
                    validators: {                        
                        numeric: {},
                        notEmpty: {}
                    }
                },
                overall: {                    
                    validators: {                        
                        numeric: {},
                        notEmpty: {}
                    }
                }                 
            }
        })
        .on('err.validator.fv', function(e, data) {
            if ((data.field === 'age')||(data.field === 'overall')) {
                data.element
                .data('fv.messages')
                .find('.help-block[data-fv-for="' + data.field + '"]').hide()
                .filter('[data-fv-validator="' + data.validator + '"]').show();
                }
            })
        .on('success.form.fv',function(e){   
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
                            $.notify({icon: 'glyphicon glyphicon-ok', message: updateSuccessMessage},{type: 'warning'});                       
                        }        
                    }
                });
            },   600);  
        });
    }
}
/****  End edit player form validation  ****/

/****  Edit league form validation  ****/
function leagueFormValidation(){
    
    //Update league name inline 
    if($.fn.editable){
        $.fn.editable.defaults.mode = 'popup';
        $.fn.editable.defaults.send = "always";
        $.fn.editableform.buttons  = '<button type="submit" class="btn btn-default editable-submit">'+alertConfirm+'</button>'+
                                     '<button type="button" class="btn btn-info editable-cancel">'+alertCancel+'</button>';
        $('#competitionName').editable({
            container: 'body',
            showbuttons: 'bottom',
            placement: 'bottom',
            ajaxOptions: {
                type: 'post',
                success:function(result){
                    if(result ==''){                     
                        $.notify({message: updateSuccessMessage});                        
                    }        
                }
            }   
        });
    }
    
    //Switch league status 
    $("input:checkbox").change(function() {
        var leagueid = $(this).attr('data-id');
        if($(this).is(":checked")) { 
            $.ajax({
                url: base + 'admin/competitions/edit_league/update_status',
                type: 'POST',
                data: {id: leagueid, activeleague: '1' },
                success:function(result){
                        if(result ==''){                     
                            $.notify({message: updateSuccessMessage});                         
                        }        
                    }
            });
        } else {
            $.ajax({
                url: base + 'admin/competitions/edit_league/update_status',
                type: 'POST',
                data: {id: leagueid, activeleague: '0'},
                success:function(result){
                    if(result ==''){                     
                        $.notify({message: updateSuccessMessage});                       
                    }        
                }
            });
        }
    }); 
} 
/****  End league form validation  ****/

/****  Init Functions  ****/
$(document).ready(function () {    
    pswFormValidation(); 
    managerFormValidation(); 
    playerFormValidation(); 
    leagueFormValidation(); 
});

