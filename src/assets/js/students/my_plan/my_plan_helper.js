(function () {

    'use strict';

    /**
     * MyPlanHelper Class
     *
     * This class contains the methods that are used in the My Plan page.
     *
     * @class MyPlanHelper
     */
    function MyPlanHelper() {
		this.planCourses = [];
        this.courseMarket = [];
    }

    /**
     * Binds the default event handlers of the My Plan page.
     */
    MyPlanHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		
	};

	//	Additional Methods
	
	/**
     * get my plan
     */
    MyPlanHelper.prototype.getPlans = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/my_plans_api/ajax_get_my_plans';
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
			
			console.log(response);
			obj.planCourses = response;
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	/**
     * get details of courses
     */
    MyPlanHelper.prototype.retrieveCourses = function () {
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
			
//			console.log(response);
			obj.courseMarket = response;
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.MyPlanHelper = MyPlanHelper;
})();
