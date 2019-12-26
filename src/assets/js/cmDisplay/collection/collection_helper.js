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
		this.datatable = undefined;
    }

    /**
     * Binds the default event handlers of the Collection page.
     */
    CollectionHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		$(document).on('click', '.uncollect-btn', function(e) {
			//	prevent parent event
			e.stopPropagation();
			var cmid = instance.datatable.row($(this).closest('tr')).data()[0];
			var buttons = [
				{
					text: SCLang.uncollect,
					click: function() {
						instance.uncollectCourschema(cmid);
						$('#msgBox').modal('hide');
					}
				}
			]
			GeneralFunctions.displayMessageBox(SCLang.uncollect, SCLang.uncollect_message, buttons);
		});
		
		$(document).on('click', '#courschemas-datatable tbody tr', function() {
			var courschema_id = instance.datatable.row($(this).closest('tr')).data()[0];
			//	redirect
			window.location.href = GlobalVariables.baseUrl + '/' + GlobalVariables.end + '/all_courschemas/' + courschema_id;
		});
		
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
//			console.log(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    /**
     * uncollect courschema version
     */
    CollectionHelper.prototype.uncollectCourschema = function (cmid) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/collections_api/ajax_uncollect_courschema';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			courschema_id: cmid
        };
		
		var obj = this;

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
//			console.log(response);
			
			if (response === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.uncollect_cm_success, 'success', 6000);
				//	post-process
				var ind;
				$.each(obj.courschemas, function(index, courschema) {
					if (courschema.id === cmid) {
						ind = index;
						return;
					}
				});
				obj.courschemas.splice(ind, 1);
				obj.datatable.ajax.reload(function() {
					GeneralFunctions.placeFooterToBottom();	//	Fix the footer gg problem
				});
			} else if (response === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.uncollect_cm_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.CollectionHelper = CollectionHelper;
})();
