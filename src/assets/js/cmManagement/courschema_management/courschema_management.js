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
		// no uploading
		$('#upload-courschema').prop('disabled', 'true');
		// select major in modal
		helper.getVisibleMaj();
		
		CourschemaManagement.initialize_editor();
		
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for CourschemaManagement page.
     */
    function _bindEventHandlers() {
		$("a[data-toggle='pill'], a[data-toggle='tab']").on('shown.bs.tab', function() {
			//	every time the tab is changed, modify footer
			GeneralFunctions.placeFooterToBottom();
		});
		
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

	exports.initialize_editor = function() {
        ace.require("ace/ext/language_tools");
        var editor = ace.edit("editor");
        editor.setOptions({
            enableLiveAutocompletion: true,	// autocompelete only
        });
        editor.setTheme("ace/theme/monokai");	// monokai mode automatically display hints
        editor.getSession().setMode("ace/mode/javascript");	// language
        editor.setFontSize(16);
        var code_content = editor.getValue();
	};
	
})(window.CourschemaManagement);
