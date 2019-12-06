window.StudentsAllCourschemas = window.StudentsAllCourschemas || {};

/**
 * Students My Appointment
 *
 * Students My Appointment javascript namespace. Contains the main functionality of the Students My Appointment
 * page.
 *
 * @module StudentsAllCourschemas
 */
(function (exports) {

    'use strict';

    /**
     * The page helper contains methods that implement each record type functionality
     * StudentsAllCourschemasHelper
     *
     * @type {Object}
     */
    var helper = {};
	var stepper = null;

    /**
     * This method initializes the Students My Appointment page.
     *
     * @param {Boolean} defaultEventHandlers Optional (false), whether to bind the default
     * event handlers or not.
     */
    exports.initialize = function (defaultEventHandlers) {
        defaultEventHandlers = defaultEventHandlers || false;

        helper = new StudentsAllCourschemasHelper();
		
		// Initializations
		StudentsAllCourschemas.initStepper();

        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for Students My Appointment page.
     */
    function _bindEventHandlers() {		
        helper.bindEventHandlers();
    }
	
    /**
     * This method initializes the bs-stepper section.
     */
	var bs_stepper_prev_btn = '<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--prev"><i class="fas fa-chevron-left"></i></button>';
	var bs_stepper_next_btn = '<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--next"><i class="fas fa-chevron-right"></i></button>';
    exports.initStepper = function () {
		//	Add progressing buttons
		var title_blocks = $('.bs-stepper .bs-stepper-titles .bs-stepper-btns');
		title_blocks.append(bs_stepper_prev_btn).append(bs_stepper_next_btn);
		title_blocks.first().find('.bs-stepper-btns--prev').addClass('disabled');
		title_blocks.last().find('.bs-stepper-btns--next').addClass('disabled');
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
//			console.log(event.detail);
		});
    };

})(window.StudentsAllCourschemas);
