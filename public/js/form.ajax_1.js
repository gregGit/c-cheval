/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 
 * Options :
 * 
 * infoContainer : Element dans lequel seront mis les messages lors du changement de statut. Peut être une chaine ou un objet jQuery. Vaut false par défaut pour indiquer qu'il n'y a pas de notification
 */

(function ($) {
    $.ajaxSubmit = function (element, options) {
        var defaults = {
            "infoContainer": false,
        };
        var plugin = this;
        plugin.options = {}
        // Référence à l'élément jQuery que le plugin affecte
        var $element = $(element);

        // Référence à l'élément HTML que le plugin affecte
        var element = element;

        // La méthode dite "constructeur" qui sera appelée
        // lorsque l'objet sera crée
        plugin.init = function () {
            plugin.options = $.extend({}, defaults, options);
            if (typeof plugin.default.infoContainer == 'string') {
                plugin.default.infoContainer = jQuery(plugin.default.infoContainer);
            }
        }

        var setEvent=function(){
            $element.submit(function(event) {
                event.preventDefault();
                event.stopPropagation();
            })
        }
        plugin.init();
    }


    // On ajoute le plugin à l'objet jQuery $.fn
    $.fn.ajaxSubmit = function (options) {
        // Pour chacuns des élément du dom à qui
        // on a assigné le plugin
        return this.each(function () {
            // Si le plugin n'as pas deja été assigné à l'élément
            if (undefined == $(this).data('ajaxSubmit')) {
                // On crée une instance du plugin
                // avec les options renseignées
                var plugin = new $.ajaxSubmit(this, options);
                $(this).data('ajaxSubmit', plugin);
            }
        });
    }
})(jQuery);


jQuery(function () {
    jQuery("form.ajax-submit").ajaxSubmit();
});
    
    
    
    
    
    jQuery("form.ajax-submit").submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        form = jQuery(this);
        form.children('.alert').alert('close').remove();
        if (!form.attr('data-no-wait-alert') || form.data('no-wait-alert') === false) {
            form.append(jQuery(getTemplate('ajWaitAlert').addClass('data-wait-alert')));
        }
        form.children().removeClass('has-error has-feedback');
        jQuery('.form-control-feedback', form).remove();
        jQuery.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json'
        })
                .done(function (data) {
                    var fct = form.data('done');
                    if (data.success == true) {
                        if (eval("typeof " + fct) == "function") {
                            window[fct](data, form);
                        }
                    } else {
                        var error_list_content = '';
                        for (var idx in data.messages) {
                            var formElement = jQuery('[name="' + idx + '"]', form);
                            formElement.parents('.form-group').addClass('has-error has-feedback');
                            formElement.parent().append('<span class="form-control-feedback" aria-hidden="true"><i class="fa fa-close"></i></span>');
                            for (var errName in data.messages[idx]) {
                                error_list_content += '<li>' + jQuery('label', formElement.parents('.form-group')).html() + data.messages[idx][errName] + '</li>';
                            }
                        }
                        error_list_content = '<ul>' + error_list_content + '</ul>';
                        var alertError = jQuery(getTemplate('ajFieldsErrorAlert'));
                        jQuery('.fields-error-list', alertError).html(error_list_content);
                        form.append(alertError);
                    }

                })
                .fail(function () {
                })
                .always(function () {
                    form.children('.alert.data-wait-alert').alert('close').remove();
                });
        ;
        return false;
    });
    jQuery('textarea.autoexpend').on('keyup', function () {

        this.style.overflow = 'hidden';
        if (this.clientHeight <= this.scrollHeight - parseInt(jQuery(this).css('line-height'))) {
            jQuery(this).animate({height: this.scrollHeight + parseInt(jQuery(this).css('line-height')) + 'px'}, 100, 'linear');
        }
    });
    jQuery('body').on('click', '[data-role="aj-delete"]', function (event) {
        event.preventDefault();
        event.stopPropagation();
        elem = jQuery(this);
        jQuery.ajax({
            url: elem.data('url'),
            type: 'DELETE',
            dataType: 'json'
        })
                .done(function (data) {
                    if (data.success == true) {
                        if (typeof elem.data('container') != 'undefined') {
                            elem.parents(elem.data('container')).remove();
                        }
                    } else {
                        alert(data.messages);
                    }
                })
                .fail(function () {
                })
                .always(function () {
                });
        ;
    });
    jQuery('body').on('show.bs.modal', '[data-role="modal-aj-form"]', function (event) {
        var openButton = jQuery(event.relatedTarget);
        var dialog = jQuery(this);
        jQuery.ajax({
            url: openButton.data('url'),
            data: openButton.data(),
            type: 'GET',
            dataType: 'json'
        })
                .done(function (data) {
                    if (data.success == true) {
                        if (typeof data.form != 'undefined') {
                            jQuery('.modal-body', dialog).html(data.form);
                        }
                    } else {
                        alert(data.messages);
                    }
                })
                .fail(function () {
                })
                .always(function () {
                });
        ;
    });
});
function getTemplate(name) {
    var t = jQuery('#' + name, '#templates');
    var clone = jQuery(t[0].innerHTML);
    return clone;
}


