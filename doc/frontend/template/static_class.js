window.StaticClass = window.StaticClass || {};	// Browser Compatibility

/**
 *
 * An example of a Static Class
 *
 * @module StaticClass
 */
(function (exports) {

    'use strict';	// strict mode execution: This means no undeclared variable usage.
	
	// an example static method
	// to call this method, write `StaticClass.exampleStaticMethod('Hi')`
    exports.exampleStaticMethod = function (param0) {
        // do sth
		console.log(param0);
    };

	// Normally static classes are for helping a web page to initialize several tools and bind helper's event handlers
    /**
     * This method initializes certain page
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;
        helper = new HelperClass();	// here we instantiate a helper class
		
		// Initializations of other tools

        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

	// Note that functions written as `function exampleLocalFunction()` can only be called LOCALLY
    /**
     * Default event handlers declaration for certain page.
     */
    function _bindEventHandlers() {
		//	bind global event handlers
		
		//	bind event handlers from the helper
        helper.bindEventHandlers();
    }

})(window.StaticClass);
