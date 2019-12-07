(function () {

    'use strict';	// strict mode execution: This means no undeclared variable usage.

    /**
     * HelperClass - Remember to change `HelperClass` to the appropriate class name you want
     *
     * This class is a template helper class that needs to be initialized for each usage
     *
     * @class HelperClass
     */
    function HelperClass() {
		//	This is like a constructor
		this.variable0 = 0;
    }

    /**
     * Binds the default event handlers used in your helper class
     */
    HelperClass.prototype.bindEventHandlers = function () {
        var instance = this;
		// normally you use "this" to represent the instance right? So why do we need to store it?
		// because in listeners, the meaning of "this" will change. If you still don't get it, try it yourself~

		// Listners
		$('.exampleElement').click(function() {
			// note that you can write listeners like this thanks to JQuery
			// If you want to write in Native Javascript, use `eventTarget.addEventListener(...)`
		});
		
		$(document).on('click', '.exampleElement', function() {
			// note that you can write listeners like this thanks to JQuery
			// BEWARE that this format is necessary, for elements that are generated through Javascript!
			// For those generated elements, `$('...').click(...)` will not work
			console.log(instance.variable0);
		});
	};

	//	Additional Methods
    /**
     * One instance method
     */
    HelperClass.prototype.exampleInstanceMethod = function () {
		//	Do whatever you want
		//	...
		
		//	Here is an example of using JQuery's AJAX 
        var input0 = $('#input0').val();
		
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/sth_api/ajax_do_sth';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			input0 : JSON.stringify(input0)
        };

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			// use response to do sth...
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.HelperClass = HelperClass;	// browser compatibility
})();
