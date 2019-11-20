window.Students = window.Students || {};

/**
 * Students
 *
 * This module contains functions that are used in the students section of the application.
 *
 * @module Students
 */
(function (exports) {

    'use strict';

    /**
     * Main javascript code for the students of CLE Peer-Tutoring | SUSTech
     */
    $(document).ready(function () {
        window.console = window.console || function () {
        }; // IE compatibility
		
		//	When the window is resized, re-define the 
		//	footer's position at the page
        $(window)
            .on('resize', function () {
                GeneralFunctions.placeFooterToBottom();
            })
            .trigger('resize');
		
		//	Loading Icon will do their work on ajax
        $(document).ajaxStart(function () {
            $('#loading').show();
        });
        $(document).ajaxStop(function () {
            $('#loading').hide();
        });
		
//		//	tooltip: my is the position of the triangle leadout,
//		//	at is the content position
//        $('.menu-item').qtip({
//            position: {
//                my: 'top center',
//                at: 'bottom center'
//            },
//            style: {
//                classes: 'qtip-green qtip-shadow custom-qtip'
//            }
//        });
		
		//	Language Selection
        GeneralFunctions.enableLanguageSelection($('#select-language'));
    });
	
	//	This is for header active state
    exports.PRIV_MY_COURSCHEMA = 'my_courschema';
    exports.PRIV_ALL_COURSCHEMAS = 'all_courschemas';
    exports.PRIV_COLLECTION = 'collection';
    exports.PRIV_MY_PLAN = 'my_plan';
    exports.PRIV_LEARNED = 'learned';

})(window.Students);
