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
        this.tags = [];
		this.faqs = [];
		this.latestQuestions = [];
		this.myQuestions = [];
//		this.myAnswerIds = [];
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
			instance.restoreTag($(this));
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
				GeneralFunctions.filterList($('#tagChoices .tag'), 'tagName', true, val);
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
					instance.tags[id].removeHtml
				);
			}, 666);
		});
		
		/**
		 * Input Titles
		 */
		var t_aqt = null;
		$('#ask_question_title').on('keyup', function() {
			if (t_aqt) {
				clearTimeout(t_aqt);
			}
			var obj = $(this);
			t_aqt = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				if (!GeneralFunctions.checkTooManyWords(obj, 50)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		});
		/**
		 * Input Descriptions
		 */
		var t_id = null;
		$('#ask_question_description').on('keyup', function() {
			if (t_id) {
				clearTimeout(t_id);
			}
			var obj = $(this);
			t_id = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				if (!GeneralFunctions.checkTooManyWords(obj, 300)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		});
		
		/**
		 * Post question button
		 */
		$('#ask_question_submit').click(function() {
			instance.postQuestions();
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
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			$.each(response, function(ind, tag) {
				var html = '<span class="tag badge badge-pill badge-info" title="' + tag.name + '" data-tag-id="' + tag.id + '" data-tag-name="' + tag.name + '">' + tag.name;
				obj.tags[tag.id] = {
					id: tag.id,
					name: tag.name,
					addHtml: html + ' <i class="add_tags fas fa-plus fa-xs"></i></span>',
					removeHtml: html + ' <i class="add_tags fas fa-times fa-xs"></i></span>'
				};
				$('#tagChoices').append(obj.tags[tag.id].addHtml);
			});
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
    
	/**
     * Remove tags from selected list and place them back to tag panel
     */
    QaHelper.prototype.restoreTag = function ($tag) {
		$tag.fadeOut(500);
		var $obj = $tag;
		var obj = this;
		setTimeout(function() {
			var id = $obj.prop('dataset').tagId;
			$obj.remove();
			$('#tagChoices').append(
				obj.tags[id].addHtml
			);
		}, 666);
    };
    
	/**
     * Get all FAQ Ids
     */
    QaHelper.prototype.getFaqs = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_get_faqs';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			obj.faqs = response;
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
    
	/**
     * Get some Latest Questions Ids
     */
    QaHelper.prototype.getLatestQuestions = function (max_num) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_get_latest_questions';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			num_limit: max_num
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			obj.latestQuestions = response;
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
    
	/**
     * Get All of the user's Question Ids
     */
    QaHelper.prototype.getMyQuestions = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_get_my_questions';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
		
			obj.myQuestions = response;
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
    
	/**
     * Post Questions
     */
    QaHelper.prototype.postQuestions = function () {
		if ($('#ask_question_title').hasClass('is-invalid') || $('#ask_question_description').hasClass('is-invalid')) {
			GeneralFunctions.displayMessageAlert(SCLang.invalid_feedback, 'danger', 6000);
			return;
		}
		var title = $('#ask_question_title').val();
		var description = $('#ask_question_description').val();
		var labels = [];
		$.each($('#ask_questions_tags .selected_tags .tag'), function(index, tagEl) {
			labels.push(tagEl.dataset.tagId);
		});
		
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_post_question';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			title: JSON.stringify(title),
			description: JSON.stringify(description),
			labels: JSON.stringify(labels)
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			if (response === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_post_question_success, 'success', 6000);
				// clear input and trigger keyup to check
				$('.ask-question-input').val('');
				$.each($('#ask_questions_tags .selected_tags .tag'), function(index, tagEl) {
					obj.restoreTag($(tagEl));
				});
				$('#ask_question_title, #ask_question_description').trigger('keyup');
			} else if (response === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_post_question_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.QaHelper = QaHelper;
})();
