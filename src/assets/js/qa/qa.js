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
//			initAnswerPagination();
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
		$.when(helper.getFaqIds()).then(helper.getQuestions(helper.faqIds, type_faq)).then(function() {
			initQuestionPagination($('#faq_pagination'), $('#faq_contents'), type_faq);
		});
		$.when(helper.getLatestQuestionIds(50)).then(helper.getQuestions(helper.latestQuestionIds, type_lq)).then(function() {
			initQuestionPagination($('#lq_pagination'), $('#lq_contents'), type_lq);
		});
		$.when(helper.getMyQuestionIds()).then(helper.getQuestions(helper.myQuestionIds, type_mq)).then(function() {
			initQuestionPagination($('#mq_pagination'), $('#mq_contents'), type_mq);
		});
	}
	
	function initQuestionPagination($pagination, $contents, type) {
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
						var html = '<a href="javascript:void(0);" class="list-group-item list-group-item-action flex-column aligh-items-start question-brief" style="padding: 20px;" data-question-id="' + item.id + '"><h5 style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + item.title + '</h5><p class="text-muted mb-0">' + moment(item.time).format('YYYY-MM-DD') + ' Answers:' + item.number_of_answers + (item.authentication === '1' ? ' <span class="text-success">authenticated</span></p></a>' : '');
						$contents.append(html);
					});
					pagination.el.show();
				}
				GeneralFunctions.placeFooterToBottom();
			}
		});
	}
	
	function initAnswerPagination($pagination, $contents, type) {
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
						var html = '<a href="javascript:void(0);" class="list-group-item list-group-item-action flex-column aligh-items-start question-brief" style="padding: 20px;" data-question-id="' + item.id + '"><h5 style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + item.title + '</h5><p class="text-muted mb-0">' + moment(item.time).format('YYYY-MM-DD') + ' Answers:' + item.number_of_answers + (item.authentication === '1' ? ' <span class="text-success">authenticated</span></p></a>' : '');
						$contents.append(html);
					});
					pagination.el.show();
				}
				GeneralFunctions.placeFooterToBottom();
			}
		});
	}

})(window.Qa);
