window.StudentsMyPlan = window.StudentsMyPlan || {};

/**
 * Students My Appointment
 *
 * Students My Appointment javascript namespace. Contains the main functionality of the Students My Appointment
 * page.
 *
 * @module StudentsMyPlan
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * StudentsMyPlanHelper
     *
     * @type {Object}
     */
    var helper = {};

    /**
     * This method initializes the Students My Appointment page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new StudentsMyPlanHelper();
		// do sth
		$('#First_grade_one_courselist').DataTable();
		$('#First_grade_two_courselist').DataTable();
		$('#First_grade_three_courselist').DataTable();
		$('#Second_grade_one_courselist').DataTable();
		$('#Second_grade_two_courselist').DataTable();
		$('#Second_grade_three_courselist').DataTable();
		$('#Third_grade_one_courselist').DataTable();
		$('#Third_grade_two_courselist').DataTable();
		$('#THird_grade_three_courselist').DataTable();
		$('#Fourth_grade_one_courselist').DataTable();
		$('#Fourth_grade_two_courselist').DataTable();
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for Students My Appointment page.
     */
    function _bindEventHandlers() {
		$("a[data-toggle='tab']").on('shown.bs.tab', function() {
			//	every time the tab is changed, modify footer
			GeneralFunctions.placeFooterToBottom();
		});
		
        helper.bindEventHandlers();
    }

})(window.StudentsMyPlan);
