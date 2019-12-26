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
		$.when(helper.retrieveCollections()).then(function() {
			//	DataTable
			Collection.initialize_courschemas();
			helper.datatable = datatable;
		});
		
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for Collection page.
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
									courschema.id, courschema.name,
									courschema.major_name, courschema.dep_name,
									'<button type="button" class="btn btn-primary btn-sm uncollect-btn">' + SCLang.uncollect + '</button>'
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

})(window.Collection);
