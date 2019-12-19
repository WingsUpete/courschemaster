window.CourschemaManagement = window.CourschemaManagement || {};

/**
 * CourschemaManagement
 *
 * @module CourschemaManagement
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * CourschemaManagementHelper
     *
     * @type {Object}
     */
    var helper = {};

	var datatable = null;
	
    /**
     * This method initializes the CourschemaManagement page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new CourschemaManagementHelper();
		
		// Initializations
//		$.when(helper.retrieveCourses()).then(function() {
//			//	DataTable
//			CourschemaManagement.initialize_courses();
//		});
		
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for CourschemaManagement page.
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
//				console.log(courses);
				
				if (courses === undefined) {
					callback({data:[]});
				}
				
				var dataArray = [];
				var subArray = [];
				for (var i = 0; i < courses.length; ++i) {
					var course = courses[i];
					helper.courseMap[course.course_code] = course;
					var lang = GlobalVariables.language;
					var course_name = undefined;
					var department = undefined;
					var semester = undefined;
					var language = undefined;
					var description = undefined;
					if (lang === 'english') {
						course_name = course.course_en_name;
						department = course.department_en_name;
						description = course.en_description;
						semester = course.en_semester;
						language = course.en_language;
					} else if (lang === '简体中文') {
						course_name = course.course_cn_name;
						department = course.department_cn_name;
						description = course.cn_description;
						semester = course.cn_semester;
						language = course.cn_language;
					}
					subArray = [
									course.course_code, course_name, course.total_credit, course.weekly_period, department,
							   		semester, language, course.exp_credit, course.pre_logic, description
							   ];
					dataArray.push(subArray);
				}
				
				callback({
					data: dataArray
				});
			},
			"columns": [
				null,
				null,
				null,
				null,
				null,
				{"visible": false},
				{"visible": false},
				{"visible": false},
				{"visible": false},
				{"visible": false}
			]
		});
	};

})(window.CourschemaManagement);
