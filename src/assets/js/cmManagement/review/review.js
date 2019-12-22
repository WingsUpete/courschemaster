window.Review = window.Review || {};

/**
 * Review
 *
 * @module Review
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * ReviewHelper
     *
     * @type {Object}
     */
    var helper = {};
	
    /**
     * This method initializes the Review page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new ReviewHelper();
		
		// Initializations

		
        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for Review page.
     */
    function _bindEventHandlers() {
		
        helper.bindEventHandlers();
    }

})(window.Review);
