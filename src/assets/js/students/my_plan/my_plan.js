window.MyPlan = window.MyPlan || {};

/**
 * My Plan
 *
 * My Plan javascript namespace. Contains the main functionality of the My Plan
 * page.
 *
 * @module MyPlan
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * MyPlanHelper
     *
     * @type {Object}
     */
    var helper = {};

    /**
     * This method initializes the My Plan page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new MyPlanHelper();
		
		// Initialization
		
		
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for My Plan page.
     */
    function _bindEventHandlers() {
		$("a[data-toggle='tab']").on('shown.bs.tab', function() {
			//	every time the tab is changed, modify footer
			GeneralFunctions.placeFooterToBottom();
		});
		
        helper.bindEventHandlers();
    }

})(window.MyPlan);
