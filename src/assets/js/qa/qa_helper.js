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
		this.searchResults = [];
		this.answers = [];
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
		}).trigger('keyup');
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
		}).trigger('keyup');
		
		/**
		 * Post question button
		 */
		$('#ask_question_submit').click(function() {
			instance.postQuestions();
		});
		
		/**
		 * Search question button
		 */
		var t_sqs = null;
		$('#qa-search').on('keyup', function() {
			if (t_sqs) {
				clearTimeout(t_sqs);
			}
			var obj = $(this);
			t_sqs = setTimeout(function() {
				instance.searchQuestion(obj.val());
			}, 300);
		}).trigger('keyup');
		
		/**
		 * Post Answer button
		 */
		$('#answer-submit').click(function() {
			instance.postAnswer();
		});
		
		/**
		 * Post Answer block
		 */
		var t_pab = null;
		$('#answer-content').on('keyup', function() {
			if (t_pab) {
				clearTimeout(t_pab);
			}
			var obj = $(this);
			t_pab = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				if (!GeneralFunctions.checkTooManyWords(obj, 250)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		}).trigger('keyup');
		
		/**
		 * Vote positive buttons
		 */
		$(document).on('click', '.vote-positive', function() {
			instance.voteAnswer($(this).closest('.question-answer'), true);
		});
		
		/**
		 * Vote negative buttons
		 */
		$(document).on('click', '.vote-negative', function() {
			instance.voteAnswer($(this).closest('.question-answer'), false);
		});
		
		/**
		 * reply buttons
		 */
		$(document).on('click', '.reply', function() {
			//	load id, cache and provider_id
			var cache = $(this).next('.reply_msg_cache').val();
			var dataset = $(this).closest('.question-answer').prop('dataset');
			$('#reply_answer_id').val(dataset.answerId);
			$('#reply_receiver_id').val(dataset.providerId);
			$('#reply-content').val(cache).trigger('keyup');
			$('#replyWindow').modal('show');
		});
		
		/**
		 * reply buttons
		 */
		$(document).on('click', '.reply-of-reply', function() {
			var $rorb = $(this).parent().find('.reply-of-reply-block');
			var display = $rorb.css('display');
			if (display === 'none') {
				$rorb.slideDown();
				$rorb.find('input').focus().trigger('keyup');
			} else {
				$rorb.slideUp();
			}
		});
		
		/**
		 * Post Reply block
		 */
		var t_prb = null;
		$('#reply-content').on('keyup', function() {
			if (t_prb) {
				clearTimeout(t_prb);
			}
			var obj = $(this);
			t_prb = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				if (!GeneralFunctions.checkTooManyWords(obj, 250)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		}).trigger('keyup');
		
		/**
		 * reply of reply block
		 */
		var t_rorb = null;
		$(document).on('keyup', '.reply-of-reply-content', function() {
			if (t_rorb) {
				clearTimeout(t_rorb);
			}
			var obj = $(this);
			t_rorb = setTimeout(function() {
				if (!GeneralFunctions.checkEmpty(obj)) {
					return;
				}
				if (!GeneralFunctions.checkTooManyWords(obj, 250)) {
					return;
				}
				//	true
				obj.removeClass('is-valid, is-invalid').addClass('is-valid');
			}, 300);
		});
		
		/**
		 * Post Reply button
		 */
		$('#reply-submit').click(function() {
			if ($('#reply-content').hasClass('is-invalid')) {
				GeneralFunctions.displayMessageAlert(SCLang.invalid_feedback, 'danger', 6000);
				return;
			}
			instance.postReply(
				$('#reply_answer_id').val(),
				$('#reply_receiver_id').val(),
				$('#reply-content').val()
			);
			$('#reply-content').val('');
			$('#replyWindow').modal('hide');
		});
		
		/**
		 * Post Reply button
		 */
		$(document).on('click', '.reply-of-reply-submit', function() {
			var $ans = $(this).closest('.question-answer');
			var $rb = $(this).closest('.reply-block');
			var $rorc = $rb.find('.reply-of-reply-content');
			if ($rorc.hasClass('is-invalid')) {
				GeneralFunctions.displayMessageAlert(SCLang.invalid_feedback, 'danger', 6000);
				return;
			}
			instance.postReply(
				$ans.prop('dataset').answerId,
				$rb.prop('dataset').receiverId,
				$rorc.val()
			);
			$rorc.val('');
			$ans.find('.reply-of-reply').click();
		});
		
		/**
		 * delete Reply button
		 */
		$(document).on('click', '.delete-reply', function() {
			var $reply_blk = $(this).closest('.reply-block');
			var buttons = [
				{
					text: SCLang.delete,
					click: function() {
						instance.deleteReply($reply_blk.prop('dataset').replyId);
						$('#msgBox').modal('hide');
					}
				}
			];
			GeneralFunctions.displayMessageBox(SCLang.delete_reply_title, SCLang.delete_reply_message, buttons);
		});
		
		/**
		 * delete Reply button
		 */
		$(document).on('click', '.delete-answer', function() {
			var $answer_blk = $(this).closest('.question-answer');
			var buttons = [
				{
					text: SCLang.delete,
					click: function() {
						instance.deleteAnswer($answer_blk.prop('dataset').answerId);
						$('#msgBox').modal('hide');
					}
				}
			];
			GeneralFunctions.displayMessageBox(SCLang.delete_answer_title, SCLang.delete_answer_message, buttons);
		});
		
		/**
		 * delete question button
		 */
		$(document).on('click', '.delete_question', function() {
			var buttons = [
				{
					text: SCLang.delete,
					click: function() {
						instance.deleteQuestion($('#question-id').val());
						$('#msgBox').modal('hide');
					}
				}
			];
			GeneralFunctions.displayMessageBox(SCLang.delete_question_title, SCLang.delete_question_message, buttons);
		});
		
		/**
		 * change faq button
		 */
		$('.change_faq').click(function() {
			instance.changeFaq(
				$('#question-id').val(),
				$('.change_faq').hasClass('selected') ? 0 : 1
			);
		});
	};

	//	Additional Methods
	
	//	------------------------ Main ---------------------------
    
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
     * Search for some questions
     */
    QaHelper.prototype.searchQuestion = function (input) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_search_questions';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			input: JSON.stringify(input)
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
//			console.log(response);
			obj.searchResults = response;
			Qa.initQuestionPagination($('#sq_pagination'), $('#sq_contents'), 'searchResults');
			
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
			
			if (response.status === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_post_question_success, 'success', 6000);
				// clear input and trigger keyup to check
				$('.ask-question-input').val('');
				$.each($('#ask_questions_tags .selected_tags .tag'), function(index, tagEl) {
					obj.restoreTag($(tagEl));
				});
				$('#ask_question_title, #ask_question_description').trigger('keyup');
				Qa.initRecommendBox();
				$('#recommend-box-myqs').click();
			} else if (response.status === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_post_question_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	//	------------------------ Question ---------------------------
	
	/**
     * get details of a question
     */
    QaHelper.prototype.retrieveQuestionDetails = function (id) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_get_question_details';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			question_id: id
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
//			console.log(response);
			obj.displayQuestionDetails(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	/**
     * display details of a question
     */
    QaHelper.prototype.displayQuestionDetails = function (data) {
		var basicInfo = data.info;
		var labels = data.labels;
		var answers = data.answers;
		//	display basic info
		$('#question-id').val(basicInfo.id);
		$('.question-title').html(basicInfo.title);
		$('.question-provider').html(basicInfo.provider_name).prop('href', 'mailto:' + basicInfo.provider_email);
		$('.question-provider-major').html(basicInfo.provider_major);
		$('.question-creation-time').html(basicInfo.time);
		$('.question-number-of-answers').html(answers.length);
		if (basicInfo.authentication === '1') {
			$('.question-authenticated').html(SCLang.authenticated);
		}
		if (basicInfo.can_be_deleted !== 1) {
			$('.delete_question').hide();
		}
		if (GlobalVariables.role.indexOf('admin') === -1) {
			$('.change_faq').hide();
		}
		if (basicInfo.faq === '1') {
			$('.change_faq').addClass('selected');
		}
		$('.question-description').html(basicInfo.description);
		//	display labels
		$('.tags').html('');
		$.each(labels, function(index, tag) {
			$('.tags').append('<span class="tag badge badge-pill badge-info" title="' + tag.name + '">' + tag.name + '</span>');
		});
		//	display answers
		this.answers = answers;
		Qa.initAnswerPagination($('#qa_pagination'), $('#qa_contents'), 'answers');
    };
    
	/**
     * Post Answer
     */
    QaHelper.prototype.postAnswer = function () {
		if ($('#answer-content').hasClass('is-invalid')) {
			GeneralFunctions.displayMessageAlert(SCLang.invalid_feedback, 'danger', 6000);
			return;
		}
		var id = $('#question-id').val();
		var content = $('#answer-content').val();
		
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_post_answer';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			question_id: id,
			content: JSON.stringify(content)
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			var obj = this;
//			console.log(response);
			
			if (response.status === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_post_answer_success, 'success', 6000);
				//	update
				obj.answers.unshift(response.info);
				$('#answer-content').val('');
				$('#answerWindow').modal('hide');
				$('#qa_pagination, #qa_contents').html('');
				Qa.initAnswerPagination($('#qa_pagination'), $('#qa_contents'), 'answers');
			} else if (response.status === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_post_answer_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-ANSWERS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
    
	/**
     * Vote Answer
     */
    QaHelper.prototype.voteAnswer = function ($answer, isPositive) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_vote_answer';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			answer_id: JSON.stringify($answer.prop('dataset').answerId),
			is_good: isPositive ? 1 : 0
        };
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			if (response === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_vote_answer_success, 'success', 6000);
				$answer.find('.vote-btns button').addClass('disabled');
				var vote_val = parseInt($answer.find('.vote-value').html());
				if (isPositive) {
					vote_val += 1;
					$answer.find('.vote-positive').removeClass('btn-outline-primary').addClass('btn-primary');
				} else {
					vote_val -= 1;
					$answer.find('.vote-negative').removeClass('btn-outline-primary').addClass('btn-primary');
				}
				$answer.find('.vote-value').html(vote_val);
			} else if (response === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_vote_answer_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
    
	/**
     * Post Replay
     */
    QaHelper.prototype.postReply = function (answer_id, receiver_id, content) {		
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_post_reply';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			answer_id: answer_id,
			content: JSON.stringify(content),
			receiver_id: receiver_id
        };
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			var obj = this;
			
			if (response.status === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_post_reply_success, 'success', 6000);
				//	update
				var ind = 0;
				$.each(obj.answers, function(index, answer) {
					if (answer.id === answer_id) {
						ind = index;
						return;
					}
				});
				if (obj.answers[ind].replies === undefined || obj.answers[ind].replies.length === 0) {
					obj.answers[ind].replies.push(response.info);
				} else {
					obj.answers[ind].replies.unshift(response.info);
				}
				$('#qa_pagination, #qa_contents').html('');
				Qa.initAnswerPagination($('#qa_pagination'), $('#qa_contents'), 'answers');
			} else if (response.status === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_post_reply_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
    
	/**
     * Delete Reply
     */
    QaHelper.prototype.deleteReply = function (reply_id) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_delete_reply';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			reply_id: reply_id
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			if (response === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_delete_reply_success, 'success', 6000);
				//	delete that record in the data sheet
				var ind = 0, jpos = 0;
				$.each(obj.answers, function(index, answer) {
					if (answer.replies !== undefined && answer.replies.length !== 0) {
						$.each(answer.replies, function(j, reply) {
							if (reply.id === reply_id) {
								ind = index;
								jpos = j;
								return;
							}
						});
					}
				});
				obj.answers[ind].replies.splice(jpos, 1);
				$('#qa_pagination, #qa_contents').html('');
				Qa.initAnswerPagination($('#qa_pagination'), $('#qa_contents'), 'answers');
			} else if (response === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_delete_reply_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
    
	/**
     * Delete Reply
     */
    QaHelper.prototype.deleteAnswer = function (answer_id) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_delete_answer';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			answer_id: answer_id
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			if (response === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_delete_answer_success, 'success', 6000);
				//	delete that record in the data sheet
				var ind = 0;
				$.each(obj.answers, function(index, answer) {
					if (answer.id === answer_id) {
						ind = index;
						return;
					}
				});
				obj.answers.splice(ind, 1);
				$('#qa_pagination, #qa_contents').html('');
				Qa.initAnswerPagination($('#qa_pagination'), $('#qa_contents'), 'answers');
			} else if (response === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_delete_answer_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
    
	/**
     * Delete Reply
     */
    QaHelper.prototype.deleteQuestion = function (question_id) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_delete_question';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			question_id: question_id
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			if (response === 'success') {
				window.location.href = GlobalVariables.main_page_url;
			} else if (response === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_delete_question_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
    
	/**
     * Delete Reply
     */
    QaHelper.prototype.changeFaq = function (question_id, faq) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/qa_api/ajax_admin_change_faq_mark';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			question_id: question_id,
			mark: faq
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			if (response === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_change_faq_success, 'success', 6000);
				$('.change_faq').toggleClass('selected');
			} else if (response === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.qa_change_faq_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.QaHelper = QaHelper;
})();
