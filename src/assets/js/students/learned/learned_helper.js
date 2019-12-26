(function () {

    'use strict';

    /**
     * LearnedHelper Class
     *
     * This class contains the methods that are used in the Learned page.
     *
     * @class LearnedHelper
     */
    function LearnedHelper() {
        this.courses = [];
		this.courseMap = {};
    }

    /**
     * Binds the default event handlers of the Learned page.
     */
    LearnedHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		
	};

	//	Additional Methods
	
	/**
     * get details of learned courses
     */
    LearnedHelper.prototype.retrieveLearned = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/students_api/ajax_get_my_learned';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			obj.courses = response;
//			console.log(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.LearnedHelper = LearnedHelper;
})();
