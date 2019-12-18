(function () {

    'use strict';

    /**
     * CourseManagementHelper Class
     *
     * This class contains the methods that are used in the Collection page.
     *
     * @class CourseManagementHelper
     */
    function CourseManagementHelper() {
        this.courses = {};
		this.timeOutVars = {};
    }

    /**
     * Binds the default event handlers of the Collection page.
     */
    CourseManagementHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		
		//	table row
		$(document).on('click', '#courses-datatable tbody tr', function() {
			instance.resetModal();
			$('#courseWindow').modal('show');
		});
		
		//	add
		$(document).on('click', '.add', function() {
			instance.resetModal();
			$('#courseWindow').modal('show');
		});
		
		//	input validators
		$.each(GlobalVariables.course_info, function(index, course) {
			instance.timeOutVars[course[0]] = null;
			$('#' + course[0]).on('keyup', function() {
				if (instance.timeOutVars[course[0]]) {
					clearTimeout(instance.timeOutVars[course[0]]);
				}
				var obj = $(this);
				instance.timeOutVars[course[0]] = setTimeout(function() {
					if (!GeneralFunctions.checkEmpty(obj)) {
						return;
					}
					//	true
					obj.removeClass('is-valid, is-invalid').addClass('is-valid');
				}, 300);
			}).trigger('keyup');
		});
		
		$('#add-course-submit').click(function() {
			alert('fuck');
		});
		
	};

	//	Additional Methods
	
	/**
     * clear modal inputs
     */
    CourseManagementHelper.prototype.resetModal = function () {
		$('#courseWindow').find('input, textarea').val('').trigger('keyup');
    };
	
	/**
     * get details of a question
     */
    CourseManagementHelper.prototype.retrieveCourses = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/course_api/ajax_get_all_course_info';
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
	
	/**
     * get details of a question
     */
    CourseManagementHelper.prototype.addCourse = function (code, chz_name, en_name, department_code, total_credit, exp_credit, weekly_period, semester, language, pre_logic, description, en_description) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/course_api/ajax_add_one_course';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			code: JSON.stringify(code),
			name: JSON.stringify(chz_name),
			en_name: JSON.stringify(en_name),
			department_code: JSON.stringify(department_code),
			credit: total_credit,
			exp_credit: exp_credit,
			weekly_period: weekly_period,
			semester: JSON.stringify(semester),
			language: JSON.stringify(language),
			pre_logic: JSON.stringify(pre_logic),
			description: JSON.stringify(description),
			en_description: JSON.stringify(en_description)
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
	
	
    window.CourseManagementHelper = CourseManagementHelper;
})();
