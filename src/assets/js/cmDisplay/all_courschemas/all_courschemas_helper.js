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
		this.collectedMark = 'fas collected';
		this.uncollectedMark = 'far uncollected';
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
			GlobalVariables.courschemaId = $(this).prop('dataset').verId;
			GlobalVariables.courschemaName = $(this).prop('dataset').verName;
			GlobalVariables.collected = $(this).closest('.search-res-item-block').find('.collect i').hasClass('collected') ? 1 : 0;
			instance.stepper.next();
			var ccHelper = CurrentCourschema.helper;
			ccHelper.getPdf();
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
		
		$(document).on('click', '.collect', function() {
			var id = $(this).closest('.search-res-item-block').find('.sel-btn').prop('dataset').verId;
			var $item = $(this).find('i');
			if ($item.hasClass('collected')) {
				instance.uncollectCourschema(id, $item);
			} else if ($item.hasClass('uncollected')) {
				instance.collectCourschema(id, $item);
			}
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
			
//			console.log(response);
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
			
//			console.log(response);
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
			
//			console.log(response);
			obj.displayResults('ver', response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Fill in search Data
     */
    AllCourschemasHelper.prototype.displayResults = function (level, items) {
		var obj = this;
		$('#sel_' + level + ' .stepper-search-res .row').html('');
		if (items.length === 0) {
			$('#sel_' + level + ' .stepper-search-res .row').append('<small class="text-muted ml-5">' + SCLang.no_record + '</small>');
		}
		$.each(items, function(index, item) {
			var addi_title;
			var addi_content;
			var addi;
			var id;
			var addiData = '';
			if (level === 'dep') {
				addi_title = SCLang.number_of_majors;
				addi_content = item.number_of_majors;
				addi = addi_title + ': ' + addi_content;
				id = item.dep_id;
				addiData = 'data-' + level + '-code="' + item.code + '"';
			} else if (level === 'maj') {
				addi_title = SCLang.number_of_courschemas;
				addi_content = item.number_of_courschemas;
				addi = addi_title + ': ' + addi_content;
				id = item.maj_id;
			} else if (level === 'ver') {
				if (GlobalVariables.loggedIn) {
					addi = '<a href="javascript:void(0);" class="collect text-warning" title="' + SCLang.collect + '"><i class="' + (item.collected === 1 ? obj.collectedMark : obj.uncollectedMark) + ' fa-star fa-lg"></i></a>';
				} else {
					addi = ' ';
				}
				id = item.ver_id;
			}
			var html = '<div class="col-xs-12 col-lg-6 col-xl-4 search-res-item-block" data-filter="' + item.name + '"><div class="card search-res-item"><div class="card-header text-right"> </div><div class="card-body text-center"><h5 class="card-title font-weight-bold">' + item.name + '</h5><hr /><button type="button" class="btn btn-outline-dark btn-block waves-effect font-weight-bold sel-' + level + '-btns sel-btn" data-' + level + '-id="' + id + '" ' + addiData + 'data-' + level + '-name="' + item.name + '"><i class="fas fa-door-open"></i> ' + SCLang.access + '</button></div><div class="card-footer text-center text-muted">' + addi + '</div></div></div>';
			$('#sel_' + level + ' .stepper-search-res .row').append(html);
		});
    };

    /**
     * collect courschema version
     */
    AllCourschemasHelper.prototype.collectCourschema = function (cmid, $item) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/collections_api/ajax_collect_courschema';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			courschema_id: cmid
        };
		
		var obj = this;

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
//			console.log(response);
			if (response === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.collect_cm_success, 'success', 6000);
				$item.removeClass('far fa-star uncollected').addClass('fas fa-star collected');
			} else if (response === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.collect_cm_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * uncollect courschema version
     */
    AllCourschemasHelper.prototype.uncollectCourschema = function (cmid, $item) {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/collections_api/ajax_uncollect_courschema';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
			courschema_id: cmid
        };
		
		var obj = this;

        $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
//			console.log(response);
			if (response === 'success') {
				GeneralFunctions.displayMessageAlert(SCLang.uncollect_cm_success, 'success', 6000);
				$item.removeClass('fas fa-star collected').addClass('far fa-star uncollected');
			} else if (response === 'fail') {
				GeneralFunctions.displayMessageAlert(SCLang.uncollect_cm_failure, 'danger', 6000);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.AllCourschemasHelper = AllCourschemasHelper;
})();
