/* ----------------------------------------------------------------------------
 * Courschemaster - Open Source Web Scheduler
 * Gain help from Easy Appointments Framework Structure
 *
 * @package     Courschemaster - Web Application for easy course schema handling
 * @author      Peter S <petershen815@gmail.com>
 * @copyright   Copyright (c) Peter S
 * @license     https://github.com/WingsUpete/courschemaster/blob/master/LICENSE.jjboom
 * @link        https://wingsupete.github.io/courschemaster/
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

window.GeneralFunctions = window.GeneralFunctions || {};

/**
 * General Functions Module
 *
 * General functions for frontend design
 *
 * @module GeneralFunctions
 */
(function (exports) {

    'use strict';

    /**
     * General Functions Constants
     */
    exports.EXCEPTIONS_TITLE = SCLang.unexpected_issues;
    exports.EXCEPTIONS_MESSAGE = SCLang.unexpected_issues_message;
    exports.WARNINGS_TITLE = SCLang.unexpected_warnings;
    exports.WARNINGS_MESSAGE = SCLang.unexpected_warnings_message;

    /**
     * This functions displays a message box. It is useful when user
     * decisions or verifications are needed.
     */
    exports.displayMessageBox = function (title, message, buttons) {
        // Check arguments integrity.
        if (title == undefined || title == '') {
            title = '<No Title Given>';
        }

        if (message == undefined || message == '') {
            message = '<No Message Given>';
        }

        if (buttons == undefined) {
            buttons = [];
        }

        // Destroy previous modal instances.
        $('#message_box').html('').remove();

        // Create the html of the message box.
        $('body').append(
            '<div id="message_box"></div>'
        );
		
		//	Modal
		var html = '<div class="modal fade top" id="msgBox" tabindex="-1" role="dialog" aria-labelledby="msgBoxLabel" aria-hidden="true" data-backdrop="false"><div class="modal-dialog modal-dialog-centered modal-lg side-modal modal-dialog-scrollable" role="document"><dic class="modal-content"><div class="modal-header"><h5 class="modal-title" id="msbBoxLabel">' + title + '</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div><div class="modal-body"><p class="text-muted">' + message + '</p><div class="exceptionsHTML"></div></div><div class="modal-footer"><span class="customized_btns"></span><button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">' + SCLang.close + '</button></div></div></div></div>';
		$('#message_box').append(html);
		
		GeneralFunctions.decodeButtons(buttons);
		
		$('#msgBox').modal('show');
    };

    /**
     * decodes the button map list and return a set of buttons as html
     */
    exports.decodeButtons = function (buttons) {
		$('.customized_btns').html('');
		$.each(buttons, function(index, button) {
			var html = '<button type="button" class="btn btn-primary btn-sm" title="' + button.text + '">' + button.text + '</button>';
			$('.customized_btns').append(html);
			$('.customized_btns button').last()[0].onclick = button.click;
		});
    };

    /**
     * Convert date to ISO date string.
     *
     * This function creates a RFC 3339 date string. This string is needed by the Google Calendar API
     * in order to pass dates as parameters.
     *
     * @param {Date} date The given date that will be transformed.

     * @return {String} Returns the transformed string.
     */
    exports.ISODateString = function (date) {
        function pad(n) {
            return n < 10 ? '0' + n : n;
        }

        return date.getUTCFullYear() + '-'
            + pad(date.getUTCMonth() + 1) + '-'
            + pad(date.getUTCDate()) + 'T'
            + pad(date.getUTCHours()) + ':'
            + pad(date.getUTCMinutes()) + ':'
            + pad(date.getUTCSeconds()) + 'Z';
    };

    /**
     * Clone JS Object
     *
     * This method creates and returns an exact copy of the provided object. It is very useful whenever
     * changes need to be made to an object without modifying the original data.
     *
     * {@link http://stackoverflow.com/questions/728360/most-elegant-way-to-clone-a-javascript-object}
     *
     * @param {Object} originalObject Object to be copied.

     * @return {Object} Returns an exact copy of the provided element.
     */
    exports.clone = function (originalObject) {
        // Handle the 3 simple types, and null or undefined
        if (null == originalObject || 'object' != typeof originalObject)
            return originalObject;

        // Handle Date
        if (originalObject instanceof Date) {
            var copy = new Date();
            copy.setTime(originalObject.getTime());
            return copy;
        }

        // Handle Array
        if (originalObject instanceof Array) {
            var copy = [];
            for (var i = 0, len = originalObject.length; i < len; i++) {
                copy[i] = GeneralFunctions.clone(originalObject[i]);
            }
            return copy;
        }

        // Handle Object
        if (originalObject instanceof Object) {
            var copy = {};
            for (var attr in originalObject) {
                if (originalObject.hasOwnProperty(attr))
                    copy[attr] = GeneralFunctions.clone(originalObject[attr]);
            }
            return copy;
        }

        throw new Error('Unable to copy obj! Its type isn\'t supported.');
    };

    /**
     * Convert AJAX exceptions to HTML.
     *
     * This method returns the exception HTML display for javascript ajax calls. It uses the Bootstrap collapse
     * module to show exception messages when the user opens the "Details" collapse component.
     *
     * @param {Array} exceptions Contains the exceptions to be displayed.
     *
     * @return {String} Returns the html markup for the exceptions.
     */
    exports.exceptionsToHtml = function (exceptions) {
        var html =
            '<div class="accordion" id="error-accordion">' +
            '<div class="accordion-group">' +
            '<div class="accordion-heading">' +
            '<button class="accordion-toggle btn btn-default btn-xs" data-toggle="collapse" ' +
            'data-parent="#error-accordion" href="#error-technical">' +
            SCLang.details +
            '</button>' +
            '</div>' +
            '<br>';

        $.each(exceptions, function (index, exception) {
            html +=
                '<div id="error-technical" class="accordion-body collapse">' +
                '<div class="accordion-inner">' +
                '<pre>' + exception.message + '</pre>' +
                '</div>' +
                '</div>';
        });

        html += '</div></div>';

        return html;
    };

    /**
     * Parse AJAX Exceptions
     *
     * This method parse the JSON encoded strings that are fetched by AJAX calls.
     *
     * @param {Array} exceptions Exception array returned by an ajax call.
     *
     * @return {Array} Returns the parsed js objects.
     */
    exports.parseExceptions = function (exceptions) {
        var parsedExceptions = [];

        $.each(exceptions, function (index, exception) {
            parsedExceptions.push($.parseJSON(exception));
        });

        return parsedExceptions;
    };

    /**
     * Makes the first letter of the string upper case.
     *
     * @param {String} str The string to be converted.
     *
     * @return {String} Returns the capitalized string.
     */
    exports.ucaseFirstLetter = function (str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    };

    /**
     * Handle AJAX Exceptions Callback
     *
     * All backend js code has the same way of dislaying exceptions that are raised on the
     * server during an ajax call.
     *
     * @param {Object} response Contains the server response. If exceptions or warnings are
     * found, user friendly messages are going to be displayed to the user.
     *
     * @return {Boolean} Returns whether the the ajax callback should continue the execution or
     * stop, due to critical server exceptions.
     */
    exports.handleAjaxExceptions = function (response) {
        if (response.exceptions) {
            response.exceptions = GeneralFunctions.parseExceptions(response.exceptions);
            GeneralFunctions.displayMessageBox(GeneralFunctions.EXCEPTIONS_TITLE, GeneralFunctions.EXCEPTIONS_MESSAGE);
            $('#message_box .modal-body .exceptionsHTML').html(GeneralFunctions.exceptionsToHtml(response.exceptions));
            return false;
        }

        if (response.warnings) {
            response.warnings = GeneralFunctions.parseExceptions(response.warnings);
            GeneralFunctions.displayMessageBox(GeneralFunctions.WARNINGS_TITLE, GeneralFunctions.WARNINGS_MESSAGE);
            $('#message_box .modal-body .exceptionsHTML').html(GeneralFunctions.exceptionsToHtml(response.warnings));
        }

        return true;
    };

    /**
     * Enable Language Selection
     *
     * Enables the language selection functionality. Must be called on every page has a
     * language selection button. This method requires the global variable 'availableLanguages'
     * to be initialized before the execution.
     *
     * @param {Object} $element Selected element button for the language selection.
     */
    exports.enableLanguageSelection = function ($element) {
        $(document).on('click', '.language', function () {
           // Change language with ajax call and refresh page.
           var postUrl = GlobalVariables.baseUrl + '/index.php/general_api/ajax_change_language';
           var postData = {
               csrfToken: GlobalVariables.csrfToken,
               language: JSON.stringify($(this).attr('data-language'))
           };
			
//			alert('language' + JSON.stringify(postData));
			
           $.post(postUrl, postData, function (response) {
               if (!GeneralFunctions.handleAjaxExceptions(response)) {
                   alert(response.exceptions);
                   return;
               }
               document.location.reload(true);

           }, 'json').fail(GeneralFunctions.ajaxFailureHandler);
        });
    };

    /**
     * AJAX Failure Handler
     *
     * @param {jqXHR} jqxhr
     * @param {String} textStatus
     * @param {Object} errorThrown
     */
    exports.ajaxFailureHandler = function (jqxhr, textStatus, errorThrown) {
        var exceptions = [
            {
                message: textStatus + ': ' + errorThrown + '<br />' + jqxhr.responseText
            }
        ];
        GeneralFunctions.displayMessageBox(GeneralFunctions.EXCEPTIONS_TITLE, GeneralFunctions.EXCEPTIONS_MESSAGE);
        $('#message_box .modal-body .exceptionsHTML').html(GeneralFunctions.exceptionsToHtml(exceptions));
    };
	
    /**
     * Super Escape HTML: https://www.npmjs.com/package/escape-html
	 *
     * @return True if the email is valid
     */
	 exports.superEscapeHTML = function (string) {
//		console.log(string);
		var matchHtmlRegExp = /["'&<>]/;
  		var str = '' + string;
  		var match = matchHtmlRegExp.exec(str);
		
  		if (!match) {
  		  return str;
  		}
		
  		var escape;
  		var html = '';
  		var index = 0;
  		var lastIndex = 0;
		
  		for (index = match.index; index < str.length; index++) {
  		  switch (str.charCodeAt(index)) {
  		    case 34: // "
  		      escape = '"';
  		      break;
  		    case 38: // &
  		      escape = '&';
  		      break;
  		    case 39: // '
  		      escape = "'";
  		      break;
  		    case 60: // <
  		      escape = '<';
  		      break;
  		    case 62: // >
  		      escape = '>';
  		      break;
  		    default:
  		      continue;
  		  }
		
  		  if (lastIndex !== index) {
  		    html += str.substring(lastIndex, index);
  		  }
		
  		  lastIndex = index + 1;
  		  html += escape;
  		}
//		console.log(lastIndex !== index ? html + str.substring(lastIndex, index) : html);
  		return lastIndex !== index ? html + str.substring(lastIndex, index) : html;
	 };
	
    /**
     * Place Footer to Bottom
	 * The footer should have an id of "page-footer"
     */
	 exports.placeFooterToBottom = function () {
		 var $footer = $('#page-footer');
		 
		 if (window.innerHeight > $('body').height()) {
			 //	If window size is larger, place the footer at the bottom
			 $footer.css({
				 'position': 'absolute',
				 'width': '100%',
				 'bottom': '0'
			 });
			 //	sidebar overlaps all
			 $('#sidebar').css({
				 'position': 'fixed',
				 'top': '70px'
			 });
		 } else {
			 //	If window is not enough for all contents, place the footer
			 //	normally at the end of the body content
			 $footer.css('position', 'static');
			 //	sidebar overlaps only main contents
			 $('#sidebar').css({
				 'position': 'absolute',
				 'top': '0'
			 });
		 }
		 
//		 alert('footer placed to bottom');
	 };
	
    /**
     * Display Message in alert box
     * 
	 * @param {String} message: A message to be put in the alert box
	 * @param {String} status: success, failure, ...
	 * @param {Number} endurance: how long will the alert last (in milliseconds)
	 * @param {List[Map{key:val}]} actions: provide labelled functions to 
	 *										build buttons within the alert box
     */
	exports.ALERTID = 0;
    exports.displayMessageAlert = function (message, status, endurance, actions) {
        message = message || 'NO MESSAGE PROVIDED FOR THIS NOTIFICATION';
		status = status || 'info';
		endurance = endurance || 10000;
		actions = actions || [];
		//	initializations finish, now go
		var actionsHtml = '';
		$.each(actions, function(index, action) {
			var actionId = action.label.toLowerCase().replace(' ', '-');
			actionsHtml += '<button id="' + actionId + '" type="button" class="btn btn-primary btn-xs">' + action.label + '</button>';
			$(document).off('click', '#' + actionId);
			$(document).on('click', '#' + actionId, action.function);
		});
		var cur_id = GeneralFunctions.ALERTID;
		GeneralFunctions.ALERTID++;
		var html = '<div id="alert' + cur_id + '" class="alert alert-' + status + ' alert-dismissible fade show font-weight-bold" role="alert" style="display:none;">' + 
			message + actionsHtml + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times fa-xs"></span></button></div>';
		$('#notification').prepend(html);
		$('#alert' + cur_id).alert().slideDown();
		setTimeout(function() {
			$('#alert' + cur_id).alert('close');
		}, endurance);
    };
	
    /**
     * Filter a list of items by certain attribute on certain input element
	 * @param {Selector} $filterItem: The list of items to be filtered
	 * @param {String} filterAttribute: the attribute of the item to be filtered upon
	 # @param {Boolean} extendedAttr: whether the provided filterAttribute is an extended attribute
	 * @param {String} filterValue: the filter value provided
     */
    exports.filterList = function ($filterItem, filterAttribute, extendedAttr, filterValue) {
		$filterItem.filter(function() {
			var display = $(this).css('display') !== 'none';
			var cur_val = extendedAttr ? $(this)[0].dataset[filterAttribute] : $(this)[0][filterAttribute];
			if (cur_val.toLowerCase().indexOf(filterValue) > -1) {
				if (!display) {
					$(this).fadeIn(300);
				}
			} else {
				if (display) {
					$(this).fadeOut(300);
				}
			}
		});
    };
	
    /**
     * Check whether an input or textarea is empty and give corresponding feedbacks
     */
    exports.checkEmpty = function ($inputEl) {
		if ($inputEl.val() === undefined) {
			alert('unexpected function parameter of GeneralFunctions.checkEmpty().');
			return false;
		}
		if ($inputEl.val().length === 0) {
			$inputEl.removeClass('is-valid, is-invalid').addClass('is-invalid');
			$inputEl.parent().find('.invalid-feedback').html(SCLang.empty_input_feedback);
		} else {
			return true;
		}
    };
	
    /**
     * Check whether an input or textarea has too many words and give corresponding feedbacks
     */
    exports.checkTooManyWords = function ($inputEl, threshold) {
		if ($inputEl.val() === undefined) {
			alert('unexpected function parameter of GeneralFunctions.checkEmpty().');
			return false;
		}
		if ($inputEl.val().length > threshold) {
			$inputEl.removeClass('is-valid, is-invalid').addClass('is-invalid');
			$inputEl.parent().find('.invalid-feedback').html(SCLang.too_many_words_feedback);
		} else {
			return true;
		}
    };
	
    /**
     * Get file extension
     */
    exports.getFileExtension = function (name) {
		return name.substring(name.lastIndexOf('.')+1);
    };
	
})(window.GeneralFunctions);
