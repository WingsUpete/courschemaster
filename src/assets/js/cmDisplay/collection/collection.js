window.Collection = window.Collection || {};

/**
 * Collection
 *
 * @module Collection
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * CollectionHelper
     *
     * @type {Object}
     */
    var helper = {};

	var datatable = null;
	
    /**
     * This method initializes the Collection page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new CollectionHelper();
		
		// Initializations
		Collection.initialize_courses();
		
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for Students My Appointment page.
     */
    function _bindEventHandlers() {
		
        helper.bindEventHandlers();
    }
	
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

})(window.Collection);
