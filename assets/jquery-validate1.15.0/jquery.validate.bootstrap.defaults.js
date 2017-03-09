/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery.validator.setDefaults({
    highlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass(errorClass).addClass(validClass);
    },
    errorPlacement: function(error, element) {
        $(error).addClass('control-label');
        if (element.attr('type') == 'file') {
            error.insertAfter(element.parent());
        } else {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    }
});