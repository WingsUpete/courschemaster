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
			console.log(helper.questions);
		});
		
		$('#faq_pagination').pagination({
			dataSource: function(done) {
				
			},
			pageSize: 5,
			showPageNumbers: true,
			showNavigator: true,
			className: 'paginationjs-theme-red',
			callback: function(data, pagination) {
				$('#faq_contents').html('');
				$.each(data, function(index, item) {
					var html = '<a href="javascript:void(0);" class="list-group-item list-group-item-action flex-column aligh-items-start" style="padding: 20px;"><h5 style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">List group item headingList group item headingList group item headingList group item headingList group item headingList group item headingList group item headingList group item headingList group item headingList group item headingList group item headingList group item headingList group item headingList group item heading</h5><p class="text-muted mb-0">2019-10-22&ensp;Answers:5&ensp;<span class="text-success">authenticated</span></p></a>';
					$('#faq_contents').append(html);
				});
				GeneralFunctions.placeFooterToBottom();
			}
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

})(window.Qa);
