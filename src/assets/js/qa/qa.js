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
		
        helper.bindEventHandlers();
    }
	
	function initRecommendBox() {
		var type_faq = 'faqs';
		var type_lq = 'latestQuestions';
		var type_mq = 'myQuestions';
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
						var html = '<a href="' + GlobalVariables.generateQLink(item.id) + '" target="_blank" class="list-group-item list-group-item-action flex-column aligh-items-start question-brief" data-question-id="' + item.id + '"><h5>' + item.title + '</h5><p class="text-muted mb-0">' + moment(item.time).format('YYYY-MM-DD') + ' ' + SCLang.number_of_answers + ':' + item.answers_cnt + (item.authentication === '1' ? ' <span class="authenticated text-success">' + SCLang.authenticated + '</span></p></a>' : '');
						$contents.append(html);
					});
					pagination.el.show();
				}
				GeneralFunctions.placeFooterToBottom();
			}
		});
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
					$contents.append('<p class="text-muted">' + SCLang.no_record + '</p>');
					pagination.el.hide();
				} else {
					$.each(data, function(index, item) {
						var html = '<div class="list-group-item list-group-item-action flex-column align-items-start question-answer" data-answer-id="' + item.id + '"><small class="text-muted"><a class="question-answer-provider" href="mailto:' + item.provider_email + '">' + item.provider_name + '</a> - <span class="question-answer-provider-major">' + item.provider_major + '</span>&ensp;&ensp;<span class="question-answer-creation-time">' + item.time + '</span>' + (item.authentication === '1' ? '&ensp;&ensp;<span class="authenticated answer-authenticated text-sucess">' + SCLang.authenticated + '</span>' : '') + '</small>';
						html += '<h5 class="question-answer-content mt-1 mb-1">' + item.content + '</h5>';
						html += '<div class="btn-group vote-btns"><button type="button" class="btn btn-outline-primary btn-sm ml-0 vote-positive"><i class="fas fa-thumbs-up"></i></button><button type="button" class="btn btn-primary btn-sm font-weight-bold vote-value">' + item.vote + '</button><button type="button" class="btn btn-outline-primary btn-sm mr-0 vote-negative"><i class="fas fa-thumbs-down"></i></button></div></div>';
						$contents.append(html);
					});
					pagination.el.show();
				}
				GeneralFunctions.placeFooterToBottom();
			}
		});
	};

})(window.Qa);
