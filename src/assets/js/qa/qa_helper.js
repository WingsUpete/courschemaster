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
        this.tags = {};
    }

    /**
     * Binds the default event handlers of the Qa page.
     */
    QaHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		
		/**
		 * When selected tags are pressed, they are removed and placed again
		 * in the tag panel
		 */
		$(document).on('click', '.tags .selected_tags .tag', function() {
			$(this).fadeOut(500);
			var $obj = $(this);
			setTimeout(function() {
				var id = $obj.prop('dataset').tagId;
				$obj.remove();
				$('#tagChoices').append(
					instance.tags[id].html
				);
			}, 666);
		});
		
		/**
		 * Filter tags for usage
		 */
		var t_st = null;
		$('#search-tags').on('keyup', function() {
			if (t_st) {
				clearTimeout(t_st);
			}
			var obj = $(this);
			t_st = setTimeout(function() {
				var val = $(obj).val().toLowerCase();
				GeneralFunctions.filterList('#tagChoices .tag', 'tagName', true, val);
			}, 300);
		});
		
		/**
		 * When a tag in the tag panel is chosen, it goes to the question box
		 */
		$(document).on('click', '#tagChoices .tag', function() {
			$(this).fadeOut(500);
			var $obj = $(this);
			setTimeout(function() {
				var id = $obj.prop('dataset').tagId;
				$obj.remove();
				$('#ask_questions_tags .selected_tags').append(
					instance.tags[id].html
				);
			}, 666);
		});
		
		
		
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
		
		var obj = this;
		
        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			$.each(response, function(ind, tag) {
				var html = '<span class="tag badge badge-pill badge-info" title="' + tag.name + '" data-tag-id="' + tag.id + '" data-tag-name="' + tag.name + '">' + tag.name + ' <i class="add_tags fas fa-plus fa-sm"></i></span>';
				obj.tags[tag.id] = {
					id: tag.id,
					name: tag.name,
					html: html
				};
				$('#tagChoices').append(html);
			});
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.QaHelper = QaHelper;
})();
