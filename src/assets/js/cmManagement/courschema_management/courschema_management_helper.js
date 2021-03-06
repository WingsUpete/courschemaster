(function () {

    'use strict';

    /**
     * CourschemaManagementHelper Class
     *
     * This class contains the methods that are used in the Collection page.
     *
     * @class CourschemaManagementHelper
     */
    function CourschemaManagementHelper() {
        this.courschemas = [];
		this.courschemaMap = {};
		this.pendingBtn = '<span class="badge badge-warning badge-pill pending-badge hide-for-now">' + SCLang.checking + '</span>';
		this.cmcFiles = [];		
		this.cmhFiles = [];
		this.compiler = MatryonaTranslateClass;
		this.dataPack = [];
		this.editor = undefined;
    }

    /**
     * Binds the default event handlers of the Collection page.
     */
    CourschemaManagementHelper.prototype.bindEventHandlers = function () {
        var instance = this;

		// Listners
		
		//	table row
		$(document).on('click', '#courses-datatable tbody tr', function() {
			alert($(this).find('td').first().html());
		});
		
		//	new
		$(document).on('click', '.new', function() {
			//
		});
		
		//	upload
		$(document).on('click', '.upload', function() {
			$('#uploadWindow').modal('show');
		});
		
		//	upload files handling
		$('.submit-files').click(function() {
			var compiler = instance.compiler;
			//	process files in frontend ground
			instance.processFrontEndFiles();
//			$('#upload-courschema').prop('disabled', 'false');
		}).trigger('click');
		
		$('#upload-courschema').click(function() {
			instance.uploadCourschemas();
		});
		
		$('#editor-submit').click(function() {
			instance.submitEdit(
				$('#edit-sel-maj option:selected').val(),
				$('#editor-filename').val(),
				$('#editor-file-extension option:selected').val(),
				instance.editor.getValue()
			);
		});
		
	};

	//	Additional Methods
	
	/**
     * Abort checking
     */
    CourschemaManagementHelper.prototype.abortChecking = function () {
		GeneralFunctions.displayMessageAlert(SCLang.upload_courschemas_rejected, 'danger', 6000);
		$.each($('.file-list-item .badge'), function(index, item) {
			var $item = $(item);
			if ($item.hasClass('badge-warning')) {
				$item.removeClass('badge-warning').addClass('badge-info');
				$item.html(SCLang.abort);
			}
		});
    };
	
	/**
     * get details of courschemas
     */
    CourschemaManagementHelper.prototype.processFrontEndFiles = function () {
		var files = $('#choose-files').prop('files');	// FileList obj
		var output_cmh = [];
		var output_cmc = [];
		var obj = this;
		obj.cmhFiles = [];
		obj.cmcFiles = [];
		$.each(files, function(index, file) {
			var name = file.name;
			var extension = GeneralFunctions.getFileExtension(name);
			var html;
			if (extension === 'cmh') {
				html = '<li class="list-group-item d-flex justify-content-between align-items-center file-list-item cmh-item" data-file-name="' + name + '"><span class="file-txt"><strong class="file-txt--name">' + name + '</strong> <small class="text-muted file-txt--addi">' + file.size + ' bytes, last modified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a') + '</small></span>' + obj.pendingBtn + '</li>';
				output_cmh.push(html);
				obj.cmhFiles.push(file);
			} else if (extension === 'cmc') {
				html = '<li class="list-group-item d-flex justify-content-between align-items-center file-list-item cmc-item" data-file-name="' + name + '"><span class="file-txt"><strong class="file-txt--name">' + name + '</strong> <small class="text-muted file-txt--addi">' + file.size + ' bytes, last modified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a') + '</small></span>' + obj.pendingBtn + '</li>';
				output_cmc.push(html);
				obj.cmcFiles.push(file);
			}
		});
		var emptyHTML = '<small class="text-muted ml-2">' + SCLang.no_record + '</small>';
		$('#upload-cmh-list').html(output_cmh.length === 0 ? emptyHTML : output_cmh.join(''));
		$('#upload-cmc-list').html(output_cmc.length === 0 ? emptyHTML : output_cmc.join(''));
    };
	
	/**
     * get details of courschemas
     */
    CourschemaManagementHelper.prototype.retrieveCourschemas = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/all_courschemas_api/ajax_get_visible_courschema';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			obj.courschemas = response;
//			console.log(response);
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	/**
     * get details of courschemas
     */
    CourschemaManagementHelper.prototype.uploadCourschemas = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/courschemas_api/ajax_upload_courschemas';
		
		var obj = this;
		
        var files = obj.cmhFiles.concat(obj.cmcFiles);
		console.log(files);
		
		var postData = new FormData();
		postData.append('csrfToken', GlobalVariables.csrfToken);
		postData.append('major_id', $('#upload-major option:selected').val());
		for (var i = 0; i < files.length; ++i) {
			postData.append('target_files[]', files[i]);
		}
//		postData.append('dataPack', obj.dataPack);
		
		return $.ajax({
			url: postUrl,
			type: 'POST',
			data: postData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(response) {
				//	Test whether response is an exception or a warning
            	if (!GeneralFunctions.handleAjaxExceptions(response)) {
            	    return;
            	}
				
				console.log(response);
				
				if (response.status) {
					GeneralFunctions.displayMessageAlert(SCLang.upload_courses_success, 'success', 6000);
					$('#upload-cmh-list').html('');
					$('#upload-cmc-list').html('');
//					$('#upload-courschema').prop('disabled', 'true');
				} else if (!response.status) {
					GeneralFunctions.displayMessageAlert(response.msg, 'danger', 6000);
				} else {
					GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
				}
			},
			error: function(e) {
				console.error(e);
			}
		});
    };
	
	/**
     * get details of courschemas
     */
    CourschemaManagementHelper.prototype.getVisibleMaj = function () {
		//	AJAX
        var postUrl = GlobalVariables.baseUrl + '/index.php/majors_api/ajax_get_visible_majors';
        var postData = {
            csrfToken: GlobalVariables.csrfToken
        };
		
		var obj = this;
		
        return $.post(postUrl, postData, function (response) {
			//	Test whether response is an exception or a warning
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
			
			$('.upload-major').html('');
			$.each(response, function(index, major) {
				$('.upload-major').append('<option value="' + major.id + '">' + major.name + '</option>');
			});
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
	/**
     * get details of courschemas
     */
    CourschemaManagementHelper.prototype.submitEdit = function (major_id, courschema_name, type, editor_content) {
    	var posturl = GlobalVariables.baseUrl + '/index.php/all_courschemas_api/ajax_submit_courschema';
    	var postData = {
    	    csrfToken: GlobalVariables.csrfToken,
    	    courschema_name:JSON.stringify(courschema_name),
    	    type:JSON.stringify(type),
    	    major_id: JSON.stringify(major_id),
    	    source_code: JSON.stringify(editor_content)
    	};
    	$.post(posturl, postData, function (response) {
    	    if(!GeneralFunctions.handleAjaxExceptions(response)){
    	        return;
    	    }
    	    
			if (response.status) {
				GeneralFunctions.displayMessageAlert(SCLang.upload_courses_success, 'success', 6000);
				obj.refreshTable();
			} else if (!response.status) {
				GeneralFunctions.displayMessageAlert(SCLang.upload_courses_failure, 'danger', 6000);
				console.error(response.msg);
			} else {
				GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
			}
			
    	}.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.CourschemaManagementHelper = CourschemaManagementHelper;
})();
