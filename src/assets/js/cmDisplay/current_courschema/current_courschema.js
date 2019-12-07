window.CurrentCourschema = window.CurrentCourschema || {};

/**
 * Students My Appointment
 *
 * Students My Appointment javascript namespace. Contains the main functionality of the Students My Appointment
 * page.
 *
 * @module CurrentCourschema
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * CurrentCourschemaHelper
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

        helper = new CurrentCourschemaHelper();
		// do sth
		$('#datatable').DataTable({
			"initComplete": function(settings, json) {
				GeneralFunctions.placeFooterToBottom();	//	Fix the footer gg problem
			},
			"drawCallback": function( settings ) {
				GeneralFunctions.placeFooterToBottom();	//	Fix the footer gg problem
			},
			"stateLoaded": function (settings, data) {
				GeneralFunctions.placeFooterToBottom();	//	Fix the footer gg problem
			}
		});
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for Students My Appointment page.
     */
    function _bindEventHandlers() {
		$("a[data-toggle='pill']").on('shown.bs.tab', function() {
			//	every time the tab is changed, modify footer
			GeneralFunctions.placeFooterToBottom();
		});
		
        helper.bindEventHandlers();
    }
	
	function initialize_courses () {
		
	}

})(window.CurrentCourschema);
