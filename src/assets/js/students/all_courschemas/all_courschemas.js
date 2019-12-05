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
		// do sth
		stepper = new Stepper($('.bs-stepper')[0], {
			linear: true,
			animation: true,
			selectors: {
				steps: '.step',
				trigger: '.step-trigger',
				stepper: '.bs-stepper'
			}
		});

        if (defaultEventHandlers) {
            _bindEventHandlers();
        }
    };

    /**
     * Default event handlers declaration for Students My Appointment page.
     */
    function _bindEventHandlers() {
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
		
        helper.bindEventHandlers();
    }

})(window.StudentsAllCourschemas);
