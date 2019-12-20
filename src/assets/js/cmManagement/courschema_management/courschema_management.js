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
		$.when(helper.retrieveCourschemas()).then(function() {
			//	DataTable
			CourschemaManagement.initialize_courschemas();
		});
		
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
	
	exports.initialize_courschemas = function () {
		datatable = $('#courschemas-datatable').DataTable({
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
									courschema.courschema_id, courschema.courschema_name,
									courschema.major_name, courschema.department_name
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
				null
			]
		});
	};

})(window.CourschemaManagement);
