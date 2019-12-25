window.StudentInfo = window.StudentInfo || {};

/**
 * StudentInfo
 *
 * @module StudentInfo
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * StudentInfoHelper
     *
     * @type {Object}
     */
    var helper = {};
	
	var datatable_info;
	var datatable_assign;
	
    /**
     * This method initializes the StudentInfo page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new StudentInfoHelper();
		
		// Initializations
		$.when(helper.retrieveInfo()).then(function() {
			//	DataTable
			StudentInfo.initialize_info();
		}).then(function() {
			helper.datatable_info = datatable_info;
		});
		$.when(helper.retrieveAvailableCourschemas()).then(function() {
			//	DataTable
			StudentInfo.initialize_assign();
		}).then(function() {
			helper.datatable_assign = datatable_assign;
		});
		
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for StudentInfo page.
     */
    function _bindEventHandlers() {
		
        helper.bindEventHandlers();
    }

	exports.initialize_info = function () {
		datatable_info = $('#students_info-datatable').DataTable({
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
				var info_pack = helper.stu_info_pack;
				
				if (info_pack === undefined) {
					callback({data:[]});
				}
				
				var dataArray = [];
				var subArray = [];
				for (var i = 0; i < info_pack.length; ++i) {
					var info = info_pack[i];
		
					subArray = [
									info.id, info.sid, info.name, info.department, info.major, info.courschema_name,
									'<button type="button" class="btn btn-primary btn-sm assign-btn">' + SCLang.assign + '</button>',
									info.courschema_id
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
				null,
				null,
				null,
				{"visible": false}
			]
		});
	};

	exports.initialize_assign = function () {
		datatable_assign = $('#assign_courschema-datatable').DataTable({
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
				var available_cm = helper.available_cm;
				
				if (available_cm === undefined) {
					callback({data:[]});
				}
				
				var dataArray = [];
				var subArray = [];
				for (var i = 0; i < available_cm.length; ++i) {
					var cm = available_cm[i];
		
					subArray = [
									cm.id, cm.name, cm.department_name, cm.major_name
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
	
})(window.StudentInfo);
