(function () {

    'use strict';

    /**
     * StudentInfoHelper Class
     *
     * This class contains the methods that are used in the Collection page.
     *
     * @class StudentInfoHelper
     */
    function StudentInfoHelper() {
        this.stu_info_pack = [];
		this.timeOutVars = {};
    }

    /**
     * Binds the default event handlers of the Collection page.
     */
    StudentInfoHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		
		
	};

	//	Additional Methods
	
	/**
     * get details of courses
     */
    StudentInfoHelper.prototype.retrieveCourses = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/course_api/ajax_get_all_course_full_info';
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
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.StudentInfoHelper = StudentInfoHelper;
})();
