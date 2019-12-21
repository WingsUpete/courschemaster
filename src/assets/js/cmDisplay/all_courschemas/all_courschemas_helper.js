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
		
		/**
		 * Filter search results
		 */
		var t_sr = null;
		$('#sel_dep-search, #sel_maj-search, #sel_ver-search').on('keyup', function() {
			if (t_sr) {
				clearTimeout(t_sr);
			}
			var $obj = $(this);
			t_sr = setTimeout(function() {
				var val = $obj.val().toLowerCase();
				GeneralFunctions.filterList($obj.parent().next().find('.search-res-item-block'), 'filter', true, val);
			}, 300);
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
			
			obj.displayResults('dep', response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Get All Majors
     */
    AllCourschemasHelper.prototype.getMajors = function (dep_id) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/all_courschemas_api/ajax_get_maj';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			dep_id: dep_id
        };
		
		var obj = this;

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			obj.displayResults('maj', response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Get All Courschema Versions
     */
    AllCourschemasHelper.prototype.getCourschemas = function (maj_id) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/all_courschemas_api/ajax_get_cm';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			maj_id: maj_id
        };
		
		var obj = this;

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			obj.displayResults('ver', response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Fill in search Data
     */
    AllCourschemasHelper.prototype.displayResults = function (level, items) {
		$('#sel_' + level + ' .stepper-search-res .row').html('');
		$.each(items, function(index, item) {
			var html = '<div class="col-xs-12 col-lg-6 col-xl-4 search-res-item-block" data-filter="' + item.name + '"><div class="card search-res-item"><div class="card-header text-right"> </div><div class="card-body text-center"><h5 class="card-title font-weight-bold">' + ((level === 'ver') ? '<sup><a href="javascript:void(0);" class="collect text-warning" title="' + SCLang.collect + '"><i class="far fa-star fa-lg"></i></a></sup> ' : '') + item.name + '</h5><hr /><button type="button" class="btn btn-outline-dark btn-block waves-effect font-weight-bold sel-' + level + '-btns sel-btn" data-dep-id="' + item.dep_id + '" data-dep-code="' + item.code + '" data-dep-name="' + item.name + '"><i class="fas fa-door-open"></i> ' + SCLang.access + '</button></div><div class="card-footer text-center text-muted">' + SCLang.number_of_majors + ': ' + item.number_of_majors + '</div></div></div>';
			$('#sel_' + level + ' .stepper-search-res .row').append(html);
		});
    };
	
    window.AllCourschemasHelper = AllCourschemasHelper;
})();
