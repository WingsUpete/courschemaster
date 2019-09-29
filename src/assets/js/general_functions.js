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
     *
     * @param {String} title The title of the message box.
     * @param {String} message The message of the dialog.
     * @param {Array} buttons Contains the dialog buttons along with their functions.
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
            buttons = [
                {
                    text: SCLang.close,
                    click: function () {
                        $('#message_box').dialog('close');
                    }
                }
            ];
        }

        // Destroy previous dialog instances.
        $('#message_box').dialog('destroy');
        $('#message_box').remove();

        // Create the html of the message box.
        $('body').append(
            '<div id="message_box" title="' + title + '">' +
            '<p>' + message + '</p>' +
            '</div>'
        );

        $("#message_box").dialog({
            autoOpen: false,
            modal: true,
            resize: 'auto',
            width: 'auto',
            height: 'auto',
            resizable: false,
            buttons: buttons,
            closeOnEscape: true
        });

        $('#message_box').dialog('open');
        $('.ui-dialog .ui-dialog-buttonset button').addClass('btn btn-default');
        $('#message_box .ui-dialog-titlebar-close').hide();
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
            $('#message_box').append(GeneralFunctions.exceptionsToHtml(response.exceptions));
            return false;
        }

        if (response.warnings) {
            response.warnings = GeneralFunctions.parseExceptions(response.warnings);
            GeneralFunctions.displayMessageBox(GeneralFunctions.WARNINGS_TITLE, GeneralFunctions.WARNINGS_MESSAGE);
            $('#message_box').append(GeneralFunctions.exceptionsToHtml(response.warnings));
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
    exports.enableLanguageSelection = function ($element, calendar) {
        // Select Language
        var html = '<ul id="language-list">';
        $.each(availableLanguages, function () {
			//	Filter out some languages
			if (this === '简体中文' || this === 'english') {
            	html += '<li class="language" data-language="' + this + '">'
                	+ GeneralFunctions.ucaseFirstLetter(this) + '</li>';
			}
        });
        html += '</ul>';

        $element.popover({
            placement: 'top',
            title: 'Select Language',
            content: html,
            html: true,
            container: 'body',
            trigger: 'manual'
        });

        $element.click(function () {
            if ($('#language-list').length === 0) {
                $(this).popover('show');
            } else {
                $(this).popover('hide');
            }

            $(this).toggleClass('active');
        });

        $(document).on('click', 'li.language', function () {
            // Change language with ajax call and refresh page.
            var postUrl = GlobalVariables.baseUrl + '/index.php/general_api/ajax_change_language';
            var postData = {
                csrfToken: GlobalVariables.csrfToken,
                language: $(this).attr('data-language')
            };
            $.post(postUrl, postData, function (response) {
                if (!GeneralFunctions.handleAjaxExceptions(response)) {
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
                message: 'Outdated Session (No Internet): ' + errorThrown + $(jqxhr.responseText).text()
            }
        ];
        GeneralFunctions.displayMessageBox(GeneralFunctions.EXCEPTIONS_TITLE, GeneralFunctions.EXCEPTIONS_MESSAGE);
        $('#message_box').append(GeneralFunctions.exceptionsToHtml(exceptions));
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
	
})(window.GeneralFunctions);
