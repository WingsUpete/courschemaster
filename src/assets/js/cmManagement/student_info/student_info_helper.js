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
        this.available_cm = [];
		this.timeOutVars = {};
		this.datatable_info = null;
		this.datatable_assign = null;
    }

    /**
     * Binds the default event handlers of the Collection page.
     */
    StudentInfoHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		$(document).on('click', '.assign-btn', function() {
			//	load and show
			var student_id = instance.datatable_info.row($(this).closest('tr')).data()[0];
			$('#assign_student_id').val(student_id);
			$('#assignWindow').modal('show');
		});
		
		$(document).on('click', '#assign_courschema-datatable tbody tr', function() {
			var student_id = $('#assign_student_id').val();
			var courschema_id = instance.datatable_assign.row($(this)).data()[0];
			var courschema_name = instance.datatable_assign.row($(this)).data()[1];
			var buttons = [
				{
					text: SCLang.assign,
					click: function() {
						instance.assignCourschema(student_id, courschema_id, courschema_name);
						$('#msgBox').modal('hide');
					}
				}
			];
			GeneralFunctions.displayMessageBox(SCLang.assign, SCLang.assign_reply_message, buttons);
		});
		
	};

	//	Additional Methods
	
	/**
     * get details of student info
     */
    StudentInfoHelper.prototype.retrieveInfo = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/general_api/ajax_get_visible_students_info';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			obj.stu_info_pack = response;
			
//			console.log(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	/**
     * get details of courses
     */
    StudentInfoHelper.prototype.retrieveAvailableCourschemas = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/all_courschemas_api/ajax_get_visible_courschema';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			obj.available_cm = response;
			
//			console.log(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	/**
     * get details of courses
     */
    StudentInfoHelper.prototype.assignCourschema = function (student_id, courschema_id, courschema_name) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/courschemas_api/ajax_assign_courschema';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			courschema_id: courschema_id,
			user_id: student_id
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			if (response === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.assign_courschema_success, 'success', 6000);
				//	reload info table
				for (var i = 0; i < obj.stu_info_pack.length; ++i) {
					var info = obj.stu_info_pack[i];
					if (info.id === student_id) {
						obj.stu_info_pack[i].courschema_name = courschema_name;
						break;
					}
				}
				obj.datatable_info.ajax.reload(function() {
					GeneralFunctions.placeFooterToBottom();	//	Fix the footer gg problem
				});
				$('#assignWindow').modal('hide');
			} else if (response === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.assign_courschema_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.StudentInfoHelper = StudentInfoHelper;
})();
