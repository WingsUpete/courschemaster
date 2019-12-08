window.AllCourschemas = window.AllCourschemas || {};

/**
 * All Courschemas
 *
 * All Courschemas javascript namespace.
 * Contains the main functionality of the All Courschemas page.
 *
 * @module AllCourschemas
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * AllCourschemasHelper
     *
     * @type {Object}
     */
    var helper = {};
	var stepper = undefined;

    /**
     * This method initializes the All Courschemas page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new AllCourschemasHelper();
		
		// Initializations
		AllCourschemas.initStepper();
		helper.getDepartments();

        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for All Courschemas page.
     */
    function _bindEventHandlers() {		
        helper.bindEventHandlers();
    }
	
    /**
     * Initializes the bs-stepper section.
     */
	var bs_stepper_prev_btn = '<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--prev"><i class="fas fa-chevron-left"></i></button>';
	var bs_stepper_next_btn = '<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--next"><i class="fas fa-chevron-right"></i></button>';
    exports.initStepper = function () {
		if ($('.bs-stepper').length == 0) {
			return false;
		}
		//	Initialize a stepper
		stepper = new Stepper($('.bs-stepper')[0], {
			linear: true,
			animation: true,
			selectors: {
				steps: '.step',
				trigger: '.step-trigger',
				stepper: '.bs-stepper'
			}
		});
		//	for bs stepper progress buttons
		$(document).on('click', '.bs-stepper .bs-stepper-btns--next', function() {
			stepper.next();
		}).on('click', '.bs-stepper .bs-stepper-btns--prev', function() {
			stepper.previous();
		});
		//	for additional events of bs stepper
		$('.bs-stepper')[0].addEventListener('shown.bs-stepper', function(event) {
			GeneralFunctions.placeFooterToBottom();	//	Fix the footer gg problem
		});
		return true;
    };

})(window.AllCourschemas);
