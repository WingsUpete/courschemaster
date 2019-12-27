window.MyPlan = window.MyPlan || {};

/**
 * My Plan
 *
 * My Plan javascript namespace. Contains the main functionality of the My Plan
 * page.
 *
 * @module MyPlan
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * MyPlanHelper
     *
     * @type {Object}
     */
    var helper = {};

	var datatable;
	
    /**
     * This method initializes the My Plan page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new MyPlanHelper();
		
		// Initialization
		$.when(helper.retrieveCourses()).then(function() {
			MyPlan.initialize_courseMarket();
		});
		
		helper.getPlans();
		
		
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for My Plan page.
     */
    function _bindEventHandlers() {
		$("a[data-toggle='tab']").on('shown.bs.tab', function() {
			//	every time the tab is changed, modify footer
			GeneralFunctions.placeFooterToBottom();
		});
		
        helper.bindEventHandlers();
    }
	
	exports.initialize_plan_courses = function () {
		datatable = $('#plan-courses-datatable').DataTable({
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
				var courschemas = helper.courschemas;
				
				if (courschemas === undefined) {
					callback({data:[]});
				}
				
				var dataArray = [];
				var subArray = [];
				for (var i = 0; i < courschemas.length; ++i) {
					var courschema = courschemas[i];
					subArray = [
									courschema.id, courschema.name,
									courschema.major_name, courschema.dep_name,
						
						
									'<button type="button" class="btn btn-primary btn-sm delete-course-btn">' + SCLang.delete + '</button>'
							   ];
					dataArray.push(subArray);
				}
				
				callback({
					data: dataArray
				});
			},
			"columns": [
				{"visible": false},
				null,
				null,
				null,
				null
			]
		});
	};
	
	exports.initialize_courseMarket = function () {
		datatable = $('#market-courses-datatable').DataTable({
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
				var courseMarket = helper.courseMarket;
				
				if (courseMarket === undefined) {
					callback({data:[]});
				}
				
				var dataArray = [];
				var subArray = [];
				for (var i = 0; i < courseMarket.length; ++i) {
					var course = courseMarket[i];
					var language = GlobalVariables.language;
					var course_name;
					var course_department;
					if (language === 'english') {
						course_name = course.course_en_name;
						course_department = course.department_en_name;
					} else if (language === '简体中文') {
						course_name = course.course_cn_name;
						course_department = course.department_cn_name;
					}
					subArray = [
									course.course_code, course_name, course.total_credit, course_department
									
							   ];
					dataArray.push(subArray);
				}
				
				callback({
					data: dataArray
				});
			}
		});
	};
	
})(window.MyPlan);
