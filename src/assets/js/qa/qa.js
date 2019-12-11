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
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new QaHelper();
		
		// Initializations
		helper.getTags();
//		var obj = $.when(helper.getLatestQuestionIds(50)).then(helper.getQuestions(helper.latestQuestionIds)).then(function() {
//			console.log(helper.questions);
//		})
		$.when(helper.getMyQuestionIds()).then(helper.getQuestions(helper.myQuestionIds)).then(function() {
			initPagination($('#faq_pagination'), $('#faq_contents'));
		});
		
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
	
	function initPagination($pagination, $contents) {
		$pagination.pagination({
			dataSource: function(done) {
				done(helper.questions);
			},
			pageSize: 5,
			showPageNumbers: true,
			showNavigator: true,
			className: 'paginationjs-theme-red',
			callback: function(data, pagination) {
				$contents.html('');
				$.each(data, function(index, item) {
					var html = '<a href="javascript:void(0);" class="list-group-item list-group-item-action flex-column aligh-items-start question-brief" style="padding: 20px;" data-question-id="' + item.id + '"><h5 style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + item.title + '</h5><p class="text-muted mb-0">' + moment(item.time).format('YYYY-MM-DD') + '&ensp;Answers:' + item.number_of_answers + (item.authentication === '1' ? '&ensp;<span class="text-success">authenticated</span></p></a>' : '');
					$contents.append(html);
				});
				GeneralFunctions.placeFooterToBottom();
			}
		});
	}

})(window.Qa);
