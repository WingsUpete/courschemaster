(function () {

    'use strict';

    /**
     * StudentsAllCourschemasHelper Class
     *
     * This class contains the methods that are used in the Students My Courschema page.
     *
     * @class StudentsAllCourschemasHelper
     */
    function StudentsAllCourschemasHelper() {
//        this.filterResults = {};
    }

    /**
     * Binds the default event handlers of the Students My Appointment page.
     */
    StudentsAllCourschemasHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		
	};

	//	Additional Methods

    /**
     * Get All Departments
     */
    StudentsAllCourschemasHelper.prototype.saveEdition = function () {
        var tutor_id = $('#tutor-id').val();
		var first_name = GeneralFunctions.superEscapeHTML($('#first-name').val());
		var last_name = GeneralFunctions.superEscapeHTML($('#last-name').val());
		var phone_number = GeneralFunctions.superEscapeHTML($('#phone-number').val());
		var address = GeneralFunctions.superEscapeHTML($('#address').val());
		var email = GeneralFunctions.superEscapeHTML($('#email').val());
		var personal_page = $('#personal-page').val();
		var introduction = GeneralFunctions.superEscapeHTML($('#introduction').val());
		var flexible_column = GeneralFunctions.superEscapeHTML($('#flexible-column').val());
		
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/admin_api/ajax_edit_tutor';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			tutor_id : tutor_id,
			first_name : JSON.stringify(first_name),
			last_name : JSON.stringify(last_name),
			personal_page : JSON.stringify(personal_page),
			introduction : JSON.stringify(introduction),
			address : JSON.stringify(address),
			flexible_column : JSON.stringify(flexible_column),
			email : JSON.stringify(email),
			phone_number : JSON.stringify(phone_number)
        };
		
		var obj = this;

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			if (response === 'success') {
				Admin.displayNotification(EALang.edit_tutor_success, undefined, "success");
			} else if (response === 'fail') {
				Admin.displayNotification(EALang.edit_tutor_fail, undefined, "failure");
			}
			
			var newName = first_name + " " + last_name;
			$('.admin-page #tutor_config .results .entry.selected')[0].title = newName;
			$('.admin-page #tutor_config .results .entry.selected strong.nameTags')[0].innerHTML = newName;
			
			//	Save, calendar needs refetching
			this.calendar_needs_retrieval = true;
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.StudentsAllCourschemasHelper = StudentsAllCourschemasHelper;
})();
