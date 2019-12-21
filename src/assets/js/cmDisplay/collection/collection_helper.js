(function () {

    'use strict';

    /**
     * CollectionHelper Class
     *
     * This class contains the methods that are used in the Collection page.
     *
     * @class CollectionHelper
     */
    function CollectionHelper() {
        this.courschemas = [];
		this.courschemaMap = {};
    }

    /**
     * Binds the default event handlers of the Collection page.
     */
    CollectionHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		
	};

	//	Additional Methods
	
	/**
     * get collected courschemas
     */
    CollectionHelper.prototype.retrieveCollections = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/collections_api/ajax_get_my_collections';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			obj.courschemas = response;
			console.log(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.CollectionHelper = CollectionHelper;
})();
