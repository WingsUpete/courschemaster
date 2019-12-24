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
//		$.when(helper.retrieveLearned()).then(function() {
//			//	DataTable
//			Learned.initialize_courses();
//		});
		
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
		datatable = $('#students_into-datatable').DataTable({
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
									info.sid, info.name, info.department, info.major, info.courschema_name,
									'<button class="btn btn-primary">'
							   ];
					dataArray.push(subArray);
				}
				
				callback({
					data: dataArray
				});
			}
		});
	};
	
})(window.StudentInfo);
