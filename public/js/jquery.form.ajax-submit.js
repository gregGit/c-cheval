/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 
 * Options :
 * 
 * feedbackElement : Element dans lequel seront mis les messages lors du changement de statut. Peut être une chaine ou un objet jQuery. Vaut false par défaut pour indiquer qu'il n'y a pas de notification
 * Peut également être précisé par le champ data-info-container
 * 
 * 
 * 
 * 
 * Evenements :
 * 'sendAjaxForm' envoi du form avec en paramètre  xhrParams
 */


(function ($) {
    $.ajaxSubmit = function (element, options) {
        var defaults = {
            "feedbackElement": false,
            "sendingClass": 'sending',
            "disableFieldsError": false,
            "formElement": false,
            "messages": {
                "sending": '<div class="alert alert-info fade in" role="alert"><i class="fa fa-circle-o-notch fa-spin"></i> Enregistrement en cours, merci de patienter</div>',
                "success": '<div class="alert alert-success fade in" role="alert"><i class="fa fa-check"></i> Les informations ont été enregistrées</div>',
                "error": '<div class="alert alert-danger fade in" role="alert"><i class="fa fa-warning"></i>Les informations saisies ne sont pas valides, et n\'ont pas été enregistrées<span class="error-list"></span></div>'
            },
            "fnShowMessage": false,
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
            if (typeof plugin.options.feedbackElement == 'string') {
                plugin.options.feedbackElement = $(plugin.options.feedbackElement);
            } else {
                if ($element.data('info-container')) {
                    plugin.options.feedbackElement = $($element.data('info-container'))
                }
            }
            if (plugin.options.feedbackElement.length < 1) {
                plugin.options.feedbackElement = false;
            } else {
                plugin.options.feedbackElement.hide();
            }

            setEvent();
        }
        
        /**
        * setMessage
        * Modifie le contenu de l'élément désigné par feedBackElement
        */

        plugin.setMessage = function (message) {
            if (plugin.options.feedbackElement === false) {
                return;
            }
            plugin.options.feedbackElement.html(message);
        }

        plugin.hideMessage = function () {
            if (plugin.options.feedbackElement === false) {
                return;
            }
            plugin.options.feedbackElement.fadeOut();
        }
        plugin.showMessage = function () {
            if (plugin.options.feedbackElement === false) {
                return;
            }
            plugin.options.feedbackElement.fadeIn();
        }
        plugin.flashMessage = function () {
            if (plugin.options.feedbackElement === false) {
                return;
            }
            plugin.options.feedbackElement.fadeIn().fadeOut( 2100, "linear");;
        }

        var doRequest = function () {
            var xhrParams = {
                url: $element.attr('action'),
                type: $element.attr('method'),
                data: dataSerialized,
                dataType: 'json'
            };
            $element.trigger('sendAjaxForm', xhrParams);
            var xhr = jQuery.ajax(xhrParams);
            return xhr;
        }

        var dataSerialized;
        var preRequest = function () {
            plugin.setMessage(plugin.options.messages.sending);
            dataSerialized = $element.serialize();
            $(':enabled', element).attr('data-send-disabled', 'true').attr('disabled', 'disabled')
            $element.addClass(plugin.options.sendingClass);
            $('.has-error', element).removeClass('has-error');
            $('.has-feedback', element).removeClass('has-feedback');
            $('.form-control-feedback', element).remove();
            plugin.showMessage();
        }
/**
* postResquest
*actions effectuées après l'envoie de la requete
*/
        var postRequest = function () {
            $('[data-send-disabled]', element).removeAttr('disabled').removeAttr('data-send-disabled');
            $element.removeClass(plugin.options.sendingClass);
        }

        var parseFieldsError = function (xErrors) {
            if (plugin.options.disableFieldsError === true) {
                return;
            }
            if (eval("typeof " + plugin.options.feedbackContainer) == 'function') {
                window[plugin.options.feedbackContainer](element, xErrors);
                return;
            }
            var error_list_content = '';
            if (typeof xErrors == 'string') {
                error_list_content = xErrors;
            } else {
                for (var idx in xErrors) {
                    var formElement = jQuery('[name="' + idx + '"]', element);
                    if (typeof plugin.options.fnMarkFieldError === "function") {
                        window[plugin.options.fnMarkFieldError](formElement, xErrors[idx]);
                    } else {
                        formElement.parents('.form-group').addClass('has-error has-feedback');
                        formElement.parent().append('<span class="form-control-feedback" aria-hidden="true"><i class="fa fa-close"></i></span>');
                        for (var errName in xErrors[idx]) {
                            error_list_content += '<li>' + jQuery('label', formElement.parents('.form-group')).html() + xErrors[idx][errName] + '</li>';
                        }
                    }
                }
                error_list_content = '<ul>' + error_list_content + '</ul>';
                var message=$(plugin.options.messages.error);
                if($('.error-list', message).length>0) {
                    $('.error-list', message).html(error_list_content);
                } else {
                    message.html(error_list_content);
                }
            }
            plugin.setMessage(message[0].outerHTML);
        }

        var setEvent = function () {
            $element.submit(function (event) {
                event.preventDefault();
                event.stopPropagation();
                preRequest();
                var xhr = doRequest();
                xhr.done(function (data, textStatus, jqXHR) {
                    if (data.success == false)
                        $element.trigger('doneAjaxForm', $element, data, textStatus, jqXHR);
                    plugin.setMessage(plugin.options.messages.success);
                    plugin.flashMessage();
                });
                xhr.fail(function (data, textStatus, errorThrown) {
                    $element.trigger('failAjaxForm', $element, data, textStatus, errorThrown);
                    plugin.setMessage(plugin.options.messages.error + " " + textStatus);
                    parseFieldsError(data.responseJSON.xErrors);
                    plugin.showMessage();
                });
                xhr.always(function (data, textStatus, jqXHR) {
                    $element.trigger('alwaysAjaxForm', data, textStatus, jqXHR);
                    postRequest();
                });


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