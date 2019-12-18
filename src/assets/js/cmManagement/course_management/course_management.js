window.CourseManagement = window.CourseManagement || {};

/**
 * CourseManagement
 *
 * @module CourseManagement
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * CourseManagementHelper
     *
     * @type {Object}
     */
    var helper = {};

	var datatable = null;
	
    /**
     * This method initializes the CourseManagement page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new CourseManagementHelper();
		
		// Initializations
		$.when(helper.retrieveCourses()).then(function() {
			//	DataTable
			CourseManagement.initialize_courses();
		});
		
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for CourseManagement page.
     */
    function _bindEventHandlers() {
		
        helper.bindEventHandlers();
    }
	
	exports.initialize_courses = function () {
		datatable = $('#courses-datatable').DataTable({
			"autoWidth": false,
			"initComplete": function(settings, json) {
				GeneralFunctions.placeFooterToBottom();	//	Fix the footer gg problem
			},
			"drawCallback": function( settings ) {
				GeneralFunctions.placeFooterToBottom();	//	Fix the footer gg problem
			},
			"stateLoaded": function (settings, data) {
				GeneralFunctions.placeFooterToBottom();	//	Fix the footer gg problem
			},
			"ajax": function(data, callback, settings) {
				var courses = helper.courses;
				if (courses === undefined) {
					callback({data:[]});
				}
				
				var dataArray = [];
				var subArray = [];
				for (var i = 0; i < courses.length; ++i) {
					var course = courses[i];
					subArray = [course.course_id, course.course_name, course.total_credit, course.weekly_period, course.department];
					dataArray.push(subArray);
				}
				
				callback({
					data: dataArray
				});
			},
//			"columns": [
//				{"visible": false},
//				null,
//				null,
//				null,
//				null
//			]
		});
	};

})(window.CourseManagement);
