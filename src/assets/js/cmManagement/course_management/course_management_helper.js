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
        this.courses = [];
		this.courseMap = {};
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
			instance.loadModal($(this));
			$('#courseWindow').modal('show');
		});
		
		//	add
		$(document).on('click', '.add', function() {
			instance.resetModal();
			$('#courseWindow').modal('show');
		});
		
		//	add
		$(document).on('click', '#delete-course', function() {
			var buttons = [
				{
					text: SCLang.delete,
					click: function() {
						instance.deleteCourse($('#course_code').val());
						$('#msgBox').modal('hide');
					}
				}
			]
			GeneralFunctions.displayMessageBox(SCLang.delete_delete_course_title, SCLang.delete_delete_course_message, buttons);
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
					if (course[4] === '1' && !GeneralFunctions.checkEmpty(obj)) {
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
				$('#course_prelogic').val(), $('#course_description').val(), $('#course_english_description').val()
			);
		});
		
		//	submit excel
		$('#submit-files').click(function() {
			instance.uploadCourses();
		});
		
	};

	//	Additional Methods
	
	/**
     * get details of courses
     */
    CourseManagementHelper.prototype.retrieveCourses = function () {
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
    CourseManagementHelper.prototype.resetModal = function () {
		$('#courseWindow').find('input, textarea').val('').trigger('keyup');
    };
	
	/**
     * load modal inputs
     */
    CourseManagementHelper.prototype.loadModal = function ($row) {
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
		$('#course_english_description').val(course.en_description);
		$('#courseWindow').find('input, textarea').trigger('keyup');
		$('#courseWindow').find('input + label, textarea + label').addClass('active');
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
			
			if (response.status === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.add_course_success, 'success', 6000);
				var course = response.obj;
				obj.courses.push(course);
				obj.courseMap[code] = course;
				$('#courseWindow').modal('hide');
				obj.refreshTable();
			} else if (response.status === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.add_course_failure, 'danger', 6000);
				console.error(response.message);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	/**
     * refresh table
     */
    CourseManagementHelper.prototype.refreshTable = function () {
		var datatable = $('#courses-datatable').DataTable();
		datatable.ajax.reload(function() {
			GeneralFunctions.placeFooterToBottom();	//	Fix the footer gg problem
		});
    };
	
	/**
     * refresh table
     */
    CourseManagementHelper.prototype.deleteCourse = function (code) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/course_api/ajax_delete_one_course_by_course_code';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			code: JSON.stringify(code)
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			if (response.status === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.delete_course_success, 'success', 6000);
				var ind = 0;
				for (var i = 0; i < obj.courses.length; ++i) {
					if (obj.courses[i].course_code === code) {
						ind = i;
						break;
					}
				}
				obj.courses.splice(ind, 1);
				obj.courseMap[code] = null;
				$('#courseWindow').modal('hide');
				obj.refreshTable();
			} else if (response.status === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.delete_course_failure, 'danger', 6000);
				console.error(response.message);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	/**
     * refresh table
     */
    CourseManagementHelper.prototype.uploadCourses = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/course_api/ajax_add_courses_by_excel';
		
        var file = $('#choose-file').prop('files')[0];
		var filename = file.name;
		var extension = filename.substring(filename.lastIndexOf('.')+1);
		if (extension != 'xls' && extension != 'xlsx') {
			GeneralFunctions.displayMessageAlert(SCLang.file_type_mismatch, 'danger', 6000);
			return null;
		}
		
		var postData = new FormData();
		postData.append('csrfToken', GlobalVariables.csrfToken);
		postData.append('target_file', file, filename);
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			if (response.status === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.upload_courses_success, 'success', 6000);
				var courses = response.courses;
				$.each(courses, function(index, course) {
					obj.courses.push(course);
					obj.courseMap[course.course_code] = course;
				});
				$('#courseWindow').modal('hide');
				obj.refreshTable();
			} else if (response.status === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.upload_courses_failure, 'danger', 6000);
				console.error(response.message);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	
    window.CourseManagementHelper = CourseManagementHelper;
})();
