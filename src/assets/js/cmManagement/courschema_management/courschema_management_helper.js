(function () {

    'use strict';

    /**
     * CourschemaManagementHelper Class
     *
     * This class contains the methods that are used in the Collection page.
     *
     * @class CourschemaManagementHelper
     */
    function CourschemaManagementHelper() {
        this.courses = [];
		this.courseMap = {};
		this.timeOutVars = {};
    }

    /**
     * Binds the default event handlers of the Collection page.
     */
    CourschemaManagementHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		
		//	table row
		$(document).on('click', '#courses-datatable tbody tr', function() {
			instance.resetModal();
			instance.loadModal($(this));
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
			if ($('#courseWindow').find('input, textarea').hasClass('is-invalid')) {
				GeneralFunctions.displayMessageAlert(SCLang.invalid_feedback, 'danger', 6000);
				return;
			}
			instance.addCourse(
				$('#course_code').val(), $('#course_chinese_name').val(), $('#course_english_name').val(),
				$('#course_department').val(), $('#course_total_credit').val(), $('#course_experiment_credit').val(),
				$('#course_weekly_period').val(), $('#course_semester').val(), $('#course_language').val(),
				$('#course_prelogic').val(), $('#course_prelogic').val(), $('#course_english_desciption').val()
			);
		});
		
	};

	//	Additional Methods
	
	/**
     * get details of a question
     */
    CourschemaManagementHelper.prototype.retrieveCourses = function () {
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
	
	/**
     * clear modal inputs
     */
    CourschemaManagementHelper.prototype.resetModal = function () {
		$('#courseWindow').find('input, textarea').val('').trigger('keyup');
    };
	
	/**
     * load modal inputs
     */
    CourschemaManagementHelper.prototype.loadModal = function ($row) {
		var course = this.courseMap[$row.find('td').first().html()];
		$('#course_code').val(course.course_code);
		$('#course_chinese_name').val(course.course_cn_name);
		$('#course_english_name').val(course.course_en_name);
		$('#course_department').val(course.department_code);
		$('#course_total_credit').val(course.total_credit);
		$('#course_experiment_credit').val(course.exp_credit);
		$('#course_weekly_period').val(course.weekly_period);
		$('#course_semester').val(course.semester);
		$('#course_language').val(course.language);
		$('#course_prelogic').val(course.pre_logic);
		$('#course_description').val(course.cn_description);
		$('#course_english_desciption').val(course.en_description);
		$('#courseWindow').find('input, textarea').trigger('keyup');
		$('#courseWindow').find('input + label, textarea + label').addClass('active');
    };
	
	/**
     * get details of a question
     */
    CourschemaManagementHelper.prototype.addCourse = function (code, chz_name, en_name, department_code, total_credit, exp_credit, weekly_period, semester, language, pre_logic, description, en_description) {
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
			
			console.log(response);
			
			if (response === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.add_course_success, 'success', 6000);
				var course = {
					course_code: code,
					course_cn_name: chz_name,
					course_en_name: en_name,
					department_code: department_code,
					total_credit: total_credit,
					exp_credit: exp_credit,
					weekly_period: weekly_period,
					semester: semester,
					language: language,
					pre_logic: pre_logic,
					cn_description: description,
					en_description: en_description
				};
				obj.courses.push(course);
				obj.courseMap[code] = course;
			} else if (response === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.add_course_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	
    window.CourschemaManagementHelper = CourschemaManagementHelper;
})();
