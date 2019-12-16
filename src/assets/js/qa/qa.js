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
     * @param {Boolean} true - question page, false - answer page
     */
    exports.initialize = function (defaultEventHandlers, questionPage) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new QaHelper();
		
		// Initializations
		if (questionPage) {
			helper.getTags();
			initRecommendBox();
			setInterval(function() {
				//	refresh every 60s
				initRecommendBox();
			}, 60000);
		} else {
			helper.retrieveQuestionDetails(GlobalVariables.qid);
		}
		
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
		
		$('#replyWindow').on('hidden.bs.modal', function() {
			//	cache
			var content = $('#reply-content').val();
			var $curAnsEl = $('.question-answer[data-answer-id="' + $('#reply_answer_id').val() + '"]');
			$curAnsEl.find('.reply_msg_cache').val(content);
			//	clear
			$('#reply-content').val('');
			$('#reply_answer_id').val('');
		});
		
        helper.bindEventHandlers();
    }
	
	function initRecommendBox() {
		var type_faq = 'faqs';
		var type_lq = 'latestQuestions';
		var type_mq = 'myQuestions';
		$('#faq_pagination, #faq_contents').html('');
		$('#lq_pagination, #lq_contents').html('');
		$('#mq_pagination, #mq_contents').html('');
		$.when(helper.getFaqs()).then(function() {
			Qa.initQuestionPagination($('#faq_pagination'), $('#faq_contents'), type_faq);
		});
		$.when(helper.getLatestQuestions(50)).then(function() {
			Qa.initQuestionPagination($('#lq_pagination'), $('#lq_contents'), type_lq);
		});
		$.when(helper.getMyQuestions()).then(function() {
			Qa.initQuestionPagination($('#mq_pagination'), $('#mq_contents'), type_mq);
		});
	}
	
	exports.initQuestionPagination = function($pagination, $contents, type) {
		$pagination.pagination({
			dataSource: function(done) {
				done(helper[type]);
			},
			pageSize: 5,
			showPageNumbers: true,
			showNavigator: true,
			className: 'paginationjs-theme-red',
			prevText: '<i class="fas fa-angle-left"></i>',
			nextText: '<i class="fas fa-angle-right"></i>',
			callback: function(data, pagination) {
				$contents.html('');
				if (data.length === 0) {
					$contents.append('<p class="text-muted">' + SCLang.no_record + '</p>');
					pagination.el.hide();
				} else {
					$.each(data, function(index, item) {
						var html = Qa.questionHTML(item);
						$contents.append(html);
					});
					pagination.el.show();
				}
				GeneralFunctions.placeFooterToBottom();
			}
		});
	};
	
	exports.questionHTML = function(data) {
		return '<a href="' + GlobalVariables.generateQLink(data.id) + '" class="list-group-item list-group-item-action flex-column aligh-items-start question-brief" data-question-id="' + data.id + '"><h5>' + data.title + '</h5><p class="text-muted mb-0">' + moment(data.time).format('YYYY-MM-DD') + ' ' + SCLang.number_of_answers + ':' + data.answers_cnt + (data.authentication === '1' ? ' <span class="authenticated text-success">' + SCLang.authenticated + '</span></p></a>' : '');
	};
	
	exports.initAnswerPagination = function($pagination, $contents, type) {
		$pagination.pagination({
			dataSource: function(done) {
				done(helper[type]);
			},
			pageSize: 10,
			showPageNumbers: true,
			showNavigator: true,
			className: 'paginationjs-theme-red',
			prevText: '<i class="fas fa-angle-left"></i>',
			nextText: '<i class="fas fa-angle-right"></i>',
			callback: function(data, pagination) {
				$contents.html('');
				if (data.length === 0) {
					$contents.append('<p class="text-muted">' + SCLang.no_answer + '</p>');
					pagination.el.hide();
				} else {
					$.each(data, function(index, item) {
						var html = Qa.answerHTML(item);
						$contents.append(html);
						$.each(item.replies, function(index, reply) {
							var replyHtml = Qa.replyHTML(reply);
							$('.reply_contents').last().append(replyHtml);
						});
					});
					Qa.handleVoteAnswer();
					Qa.handlePriviledge();
					pagination.el.show();
				}
				GeneralFunctions.placeFooterToBottom();
			}
		});
	};
	
	exports.answerHTML = function(data) {
		var html = '<div class="list-group-item list-group-item-action flex-column align-items-start question-answer" data-answer-id="' + data.id + '" data-provider-id="' + data.provider_id + '"><small class="text-muted"><a class="question-answer-provider" href="mailto:' + data.provider_email + '">' + data.provider_name + '</a>' + (data.role.toLowerCase().indexOf('admin') > -1 ? (' <span class="text-danger">' + SCLang.admin + '</span>') : '') + ' - <span class="question-answer-provider-major">' + data.provider_major + '</span>  <span class="question-answer-creation-time">' + data.time + '</span>' + (data.authentication === '1' ? ('  <span class="authenticated answer-authenticated text-success">' + SCLang.authenticated + '</span>') : '') + ' <a class="reply" href="javascript:void(0);">' + SCLang.reply + '</a><input class="reply_msg_cache" value="" type="hidden" />' + (data.can_be_deleted === 1 ? ' <a href="javascript:void(0);" class="delete-reply">' + SCLang.delete + '</a>' : '') + '</small>';
		html += '<h5 class="question-answer-content mt-1 mb-1">' + data.content + '</h5>';
		html += '<div class="row justify-content-start pl-3 mb-1"><div class="btn-group vote-btns" data-user-vote-status="' + data.user_vote_status + '"><button type="button" class="btn btn-outline-primary btn-sm ml-0 vote-positive"><i class="fas fa-thumbs-up"></i></button><button type="button" class="btn btn-primary btn-sm font-weight-bold vote-value">' + data.vote + '</button><button type="button" class="btn btn-outline-primary btn-sm mr-0 vote-negative"><i class="fas fa-thumbs-down"></i></button></div></div>' + '<div class="list-group reply_contents"></div></div>';
		return html;
	};
	
	exports.replyHTML = function(data) {
		return '<small class="reply-block" data-reply-id="' + data.id + '" data-receiver-id="' + data.receiver_id + '" data-sender-id="' + data.sender_id + '"><span class="text-muted"><a href="mailto:' + data.receiver_email + '">@<span class="reply-detail-receiver">' + data.receiver_name + '</span></a></span> <span class="reply-detail-content font-weight-bold">' + data.content + '</span> <span class="text-muted">- <a href="mailto:' + data.sender_email + '" class="reply-detail-sender">' + data.sender_name + '</a> <span class="reply-detail-time">' + data.timestamp + '</span>' + ' <a class="reply-of-reply" href="javascript:void(0);">' + SCLang.reply + '</a>' + (data.can_be_deleted === 1 ? ' <a href="javascript:void(0);" class="delete-reply">' + SCLang.delete + '</a>' : '') + '<div class="reply-of-reply-block"><div class="md-form md-outline mt-0 mb-0"><input type="text" class="form-control form-control-sm mt-1 mb-1 is-invalid reply-of-reply-content" max="150" /><div class="invalid-feedback ml-1"></div></div><div class="row pl-2"><button type="button" class="btn btn-primary btn-sm reply-of-reply-submit pl-3 pr-3 pt-1 pb-1" style="border-radius: 10px;text-transform:none;">' + SCLang.submit + '</button></div></div></span></small>';
	};
	
	exports.handleVoteAnswer = function() {
		$.each($('.vote-btns'), function(index, btn_group) {
			var vote_status = btn_group.dataset.userVoteStatus;
			switch (vote_status) {
				case '0': break;	// not yet voted or not logged in
				case '1': {
					//	voted positive
					$(btn_group).find('button').addClass('disabled');
					$(btn_group).find('.vote-positive').removeClass('btn-outline-primary').addClass('btn-primary');
					break;
				}
				case '-1': {
					//	voted negative
					$(btn_group).find('button').addClass('disabled');
					$(btn_group).find('.vote-negative').removeClass('btn-outline-primary').addClass('btn-primary');
					break;
				}
				default: break;
			}
		});
	};
	
	exports.handlePriviledge = function() {
		if (GlobalVariables.logged_in === 'false') {
			if (!$('.vote-btns button').hasClass('disabled')) {
				$('.vote-btns button').addClass('disabled');
			}
			$('.reply').hide();
		}
	};

})(window.Qa);
