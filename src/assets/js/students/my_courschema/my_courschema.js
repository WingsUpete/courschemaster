window.StudentsMyCourschema = window.StudentsMyCourschema || {};

/**
 * Students My Appointment
 *
 * Students My Appointment javascript namespace. Contains the main functionality of the Students My Appointment
 * page.
 *
 * @module StudentsMyCourschema
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * StudentsMyCourschemaHelper
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

        helper = new StudentsMyCourschemaHelper();
		// do sth
		$('#General_compulsory_courselist').DataTable();
		$('#Professional_foundation_courselist').DataTable();
		$('#Professional_core_courselist').DataTable();
		$('#Professional_elective_courselist').DataTable();
		$('#General_elective_courselist').DataTable();
		$('#Practice_courselist').DataTable();
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

})(window.StudentsMyCourschema);
