(function () {

    'use strict';

    /**
     * CurrentCourschemaHelper Class
     *
     * This class contains the methods that are used in the Current Courschema page.
     *
     * @class CurrentCourschemaHelper
     */
    function CurrentCourschemaHelper() {
        this.filterResults = {};
    }

    /**
     * Binds the default event handlers of the Current Appointment page.
     */
    CurrentCourschemaHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		
	};

	//	Additional Methods
	
	/**
     * get details of courschemas
     */
    CurrentCourschemaHelper.prototype.retrieveCourschemas = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/current_courschema_api/ajax_get_ccBasic';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
//			console.log(response);
			GlobalVariables.courschemaId = response.id;
			GlobalVariables.courschemaName = response.name;
			GlobalVariables.collected = response.collected;
			
			//	now we can get pdf in current courschema page
			obj.getPdf();
			obj.getGraph();
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	/**
     * get pdf
     */
    CurrentCourschemaHelper.prototype.getPdf = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/current_courschema_api/ajax_get_pdf';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			courschema_id: GlobalVariables.courschemaId
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
//			console.log(response);
			$('#cc-pdf-window').prop('src', response.file_url);
			$('#cc-pdf-download a').prop('href', response.download_link);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	/**
     * get graph
     */
    CurrentCourschemaHelper.prototype.getGraph = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/current_courschema_api/ajax_get_graph_json';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			courschema_id: GlobalVariables.courschemaId
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
//			console.log(response);
			var data = JSON.parse(response);
			var treeData = data_transform(data);
			tmp(treeData);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.CurrentCourschemaHelper = CurrentCourschemaHelper;
})();
