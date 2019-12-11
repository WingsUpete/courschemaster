(function () {

    'use strict';

    /**
     * AllCourschemasHelper Class
     *
     * This class contains the methods that are used in the All Courschemas page.
     *
     * @class AllCourschemasHelper
     */
    function AllCourschemasHelper() {
        this.departments = {};
		this.majors = {};
		this.courschemas = {};
		this.stepper = undefined;
    }

    /**
     * Binds the default event handlers of the All Courschemas page.
     */
    AllCourschemasHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		$(document).on('click', '.sel-dep-btns', function() {
			var dep_id = $(this).prop('dataset').depId;
			alert(dep_id);
			instance.stepper.next();
			instance.getMajors(dep_id);
		});
		$(document).on('click', '.sel-maj-btns', function() {
			var maj_id = $(this).prop('dataset').majId;
			instance.stepper.next();
			instance.getCourschemas(maj_id);
		});
		$(document).on('click', '.sel-ver-btns', function() {
			instance.stepper.next();
		});
		
	};

	//	Additional Methods

    /**
     * Get All Departments
     */
    AllCourschemasHelper.prototype.getDepartments = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/all_courschemas_api/ajax_get_dep';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };
		
		var obj = this;

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			obj.displayDepartments(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Fill in Departments Data
     */
    AllCourschemasHelper.prototype.displayDepartments = function (departments) {
		$('#sel_dep .stepper-search-res .row').html('');
		$.each(departments, function(index, department) {
			var html = '<div class="col-xs-12 col-lg-6 col-xl-4"><div class="card search-res-item"><div class="card-header text-right">&ensp;</div><div class="card-body text-center"><h5 class="card-title font-weight-bold"><sup><a href="javascript:void(0);" class="collect-dep text-warning" title="Collect"><i class="far fa-star fa-lg"></i></a></sup>&nbsp;' + department.name + '</h5><hr /><button type="button" class="btn btn-outline-dark btn-block waves-effect font-weight-bold sel-dep-btns" data-dep-id="' + department.dep_id + '" data-dep-code="' + department.code + '"><i class="fas fa-door-open"></i>&ensp;' + SCLang.access + '</button></div><div class="card-footer text-center text-muted">' + SCLang.number_of_majors + ': ' + department.number_of_majors + '</div></div></div>';
			$('#sel_dep .stepper-search-res .row').append(html);
		});
    };

    /**
     * Get All Majors
     */
    AllCourschemasHelper.prototype.getMajors = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/all_courschemas_api/ajax_get_maj';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			dep_id: 28
        };

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			console.log(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Get All Courschema Versions
     */
    AllCourschemasHelper.prototype.getCourschemas = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/all_courschemas_api/ajax_get_cm';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			maj_id: 1
        };

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			console.log(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.AllCourschemasHelper = AllCourschemasHelper;
})();
