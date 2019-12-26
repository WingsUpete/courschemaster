window.CurrentCourschema = window.CurrentCourschema || {};

/**
 * Current Courschema
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
    exports.helper = {};

	var datatable = null;
	
    /**
     * This method initializes the Current Courschema page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        CurrentCourschema.helper = new CurrentCourschemaHelper();
		
		// Initializations
		if (GlobalVariables.retrieveIdFirst) {
			CurrentCourschema.helper.retrieveCourschemas();
		}
		
		CurrentCourschema.initialize_courses();
		
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for Current Courschema page.
     */
    function _bindEventHandlers() {
		$("a[data-toggle='pill'], a[data-toggle='tab']").on('shown.bs.tab', function() {
			//	every time the tab is changed, modify footer
			GeneralFunctions.placeFooterToBottom();
		});
		
        CurrentCourschema.helper.bindEventHandlers();
    }

    /**
     * Initializes the datatable section.
     */
	exports.initialize_courses = function () {
		datatable = $('#courses-datatable').DataTable({
			"autoWidth": true,
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
				
			}
		});
	};

})(window.CurrentCourschema);
