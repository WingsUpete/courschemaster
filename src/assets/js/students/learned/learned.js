window.Learned = window.Learned || {};

/**
 * Learned
 *
 * Learned javascript namespace. Contains the main functionality of the Learned
 * page.
 *
 * @module Learned
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * LearnedHelper
     *
     * @type {Object}
     */
    var helper = {};

	var datatable= undefined;
	
    /**
     * This method initializes the Learned page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new LearnedHelper();
		
		// Initializations
		$.when(helper.retrieveLearned()).then(function() {
			//	DataTable
			Learned.initialize_courses();
		});

        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for Learned page.
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
		
					subArray = [
									course.course_code, course.course_name, course.credit, course.period, course.prerequisite_stat, course.department_name
							   ];
					dataArray.push(subArray);
				}
				
				callback({
					data: dataArray
				});
			}
		});
	};

})(window.Learned);
