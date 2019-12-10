(function () {

    'use strict';

    /**
     * QaHelper Class
     *
     * This class contains the methods that are used in the Qa page.
     *
     * @class QaHelper
     */
    function QaHelper() {
        this.filterResults = {};
    }

    /**
     * Binds the default event handlers of the Qa page.
     */
    QaHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		
		/**
		 * When selected tags are pressed, they are removed
		 */
		$(document).on('click', '.tags .selected_tags .tag', function() {
			$(this).fadeOut().remove();
		});
//		/**
//		 * When more tags button is pressed, open a modal of tag pane
//		 */
//		$(document).on('click', '.tags .tag-btn', function() {
//			alert('open');
//		});
		
		
	};

	//	Additional Methods
    
	/**
     * Get All Courschema Versions
     */
    QaHelper.prototype.getTags = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_get_all_labels';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			$.each(response, function(ind, tag) {
				var html = '<span class="tag badge badge-pill badge-info" data-tag-id="' + tag.id + '" data-tag-name="' + tag.name + '">' + tag.name + '&ensp;<i class="add_tags fas fa-plus fa-sm"></i></span>';
				$('#tagChoices').append(html);
			});
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.QaHelper = QaHelper;
})();
