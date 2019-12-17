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
		
		//	code
		var t_code = null;
		$('#course_code').on('keyup', function() {
			if (t_code) {
				clearTimeout(t_code);
			}
			var obj = $(this);
			t_code = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		}).trigger('keyup');
		//	chinese name
		var t_chn = null;
		$('#course_chinese_name').on('keyup', function() {
			if (t_chn) {
				clearTimeout(t_chn);
			}
			var obj = $(this);
			t_chn = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		}).trigger('keyup');
		//	english name
		var t_enn = null;
		$('#course_english_name').on('keyup', function() {
			if (t_enn) {
				clearTimeout(t_enn);
			}
			var obj = $(this);
			t_enn = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		}).trigger('keyup');
		//	english name
		var t_ctc = null;
		$('#course_total_credit').on('keyup', function() {
			if (t_ctc) {
				clearTimeout(t_ctc);
			}
			var obj = $(this);
			t_ctc = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		}).trigger('keyup');
		//	english name
		var t_cec = null;
		$('#course_experiment_credit').on('keyup', function() {
			if (t_cec) {
				clearTimeout(t_cec);
			}
			var obj = $(this);
			t_cec = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		}).trigger('keyup');
		//	english name
		var t_cwp = null;
		$('#course_weekly_period').on('keyup', function() {
			if (t_cwp) {
				clearTimeout(t_cwp);
			}
			var obj = $(this);
			t_cwp = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		}).trigger('keyup');
		//	english name
		var t_cs = null;
		$('#course_semester').on('keyup', function() {
			if (t_cs) {
				clearTimeout(t_cs);
			}
			var obj = $(this);
			t_cs = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		}).trigger('keyup');
//		//	english name
//		var t_ctc = null;
//		$('#course_total_credit').on('keyup', function() {
//			if (t_ctc) {
//				clearTimeout(t_ctc);
//			}
//			var obj = $(this);
//			t_ctc = setTimeout(function() {
//				if (!GeneralFunctions.checkEmpty(obj)) {
//					return;
//				}
//				//	true
//				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
//			}, 300);
//		}).trigger('keyup');
//		//	english name
//		var t_ctc = null;
//		$('#course_total_credit').on('keyup', function() {
//			if (t_ctc) {
//				clearTimeout(t_ctc);
//			}
//			var obj = $(this);
//			t_ctc = setTimeout(function() {
//				if (!GeneralFunctions.checkEmpty(obj)) {
//					return;
//				}
//				//	true
//				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
//			}, 300);
//		}).trigger('keyup');
//		//	english name
//		var t_ctc = null;
//		$('#course_total_credit').on('keyup', function() {
//			if (t_ctc) {
//				clearTimeout(t_ctc);
//			}
//			var obj = $(this);
//			t_ctc = setTimeout(function() {
//				if (!GeneralFunctions.checkEmpty(obj)) {
//					return;
//				}
//				//	true
//				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
//			}, 300);
//		}).trigger('keyup');
//		//	english name
//		var t_ctc = null;
//		$('#course_total_credit').on('keyup', function() {
//			if (t_ctc) {
//				clearTimeout(t_ctc);
//			}
//			var obj = $(this);
//			t_ctc = setTimeout(function() {
//				if (!GeneralFunctions.checkEmpty(obj)) {
//					return;
//				}
//				//	true
//				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
//			}, 300);
//		}).trigger('keyup');
		
	};

	//	Additional Methods
	
	/**
     * clear modal inputs
     */
    CourseManagementHelper.prototype.resetModal = function () {
		$('#courseWindow').find('input, textarea').val('');
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
