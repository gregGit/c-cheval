/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(function () {
    
    setAddElementButton();

    jQuery("form#movement").on('click', '#addElementForm', appendAddElementForm);
    jQuery("form#movement").on('click', '.btn-remove-element', function (event) {
        event.preventDefault();
        event.stopPropagation();
        jQuery(this).parents('fieldset').get(0).remove();

    });

});


function appendAddElementForm(event) {
    event.preventDefault();
    event.stopPropagation();
    var index = parseInt(jQuery('fieldset.movement-element').children('fieldset').length);
    var lastFs = jQuery('fieldset.movement-element').children('fieldset').last();
    var clone = jQuery(jQuery('span[data-template]', 'fieldset.movement-element').data('template').replace(/__index__/g, index));
    jQuery('[name*="label"]', clone).wrap('<div class="input-group"></div>');
    jQuery('[name*="label"]', clone).parent('.input-group').append('<span class="input-group-btn"><button type="button" name="append-button" class="btn btn-sm btn-danger btn-remove-element" value=""><i class="fa fa-remove"></i></button></span>');
    jQuery('[name*="position"]', clone).val(index + 1);
    clone.insertAfter(lastFs);
    jQuery('input:first', clone).focus();
}
function setAddElementButton() {
    //Ajoute le bouton + au formulaire  élément
    var t = document.querySelector('#addElementButton');
    var clone = document.importNode(t.content, true);
    jQuery('.movement-element', "form#movement").append(clone);
}
function addMovement(data, form) {
    jQuery('.reprise-movements').append(data.rowHtml);
    jQuery('[name="position"]', form).val(parseInt(data.rowDatas.position) + 1);
}

function mainValidated(data, form) {
    form.append(data.rowHtml);
}