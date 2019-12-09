(function () {

    'use strict';

    /**
     * AllCourschemasHelper Class
     *
     * This class contains the methods that are used in the All Courschemas page.
     *
     * @class AllCourschemasHelper
     */
    function AllCourschemasHelper() {
        this.RetrievedResults = {};
		this.stepper = undefined;
    }

    /**
     * Binds the default event handlers of the All Courschemas page.
     */
    AllCourschemasHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		$(document).on('click', '.sel-dep-btns', function() {
			var dep_id = $('.sel-dep-btns').attr('data-dep-id');
			instance.stepper.next();
			instance.getMajors(dep_id);
		});
		$(document).on('click', '.sel-maj-btns', function() {
			var maj_id = $('.sel-maj-btns').attr('data-maj-id');
			instance.stepper.next();
			instance.getCourschemas(maj_id);
		});
		$(document).on('click', '.sel-ver-btns', function() {
			instance.stepper.next();
		});
		
	};

	//	Additional Methods

    /**
     * Get All Departments
     */
    AllCourschemasHelper.prototype.getDepartments = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/all_courschemas_api/ajax_get_dep';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };
		
//		alert('get_dep' + JSON.stringify(postData));

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			console.log(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Get All Majors
     */
    AllCourschemasHelper.prototype.getMajors = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/all_courschemas_api/ajax_get_maj';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			dep_id: 1
        };

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			console.log(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Get All Courschema Versions
     */
    AllCourschemasHelper.prototype.getCourschemas = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/all_courschemas_api/ajax_get_cm';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			maj_id: 1
        };

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			console.log(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.AllCourschemasHelper = AllCourschemasHelper;
})();
