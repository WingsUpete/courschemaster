window.Qa = window.Qa || {};

/**
 * Qa
 *
 * @module Qa
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * QaHelper
     *
     * @type {Object}
     */
    var helper = {};
	
    /**
     * This method initializes the Qa page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new QaHelper();
		
		// Initializations
		helper.getTags();
//		helper.getLatestQuestionIds(50);
		helper.getMyQuestionIds();
		helper.getQuestions(helper.myQuestionIds);
		
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for Qa page.
     */
    function _bindEventHandlers() {
		$("a[data-toggle='pill'], a[data-toggle='tab']").on('shown.bs.tab', function() {
			//	every time the tab is changed, modify footer
			GeneralFunctions.placeFooterToBottom();
		});
		
        helper.bindEventHandlers();
    }

})(window.Qa);
