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
		this.pendingBtn = '<span class="badge badge-warning badge-pill pending-badge">' + SCLang.checking + '</span>';
		this.cmcFiles = [];		
		this.cmhFiles = [];
		this.compiler = MatryonaTranslateClass;
		this.dataPack = [];
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
			alert('new');
		});
		
		//	upload
		$(document).on('click', '.upload', function() {
			$('#uploadWindow').modal('show');
		});
		
		//	upload files handling
		$('#submit-files').click(function() {
			var compiler = instance.compiler;
			//	process files in frontend ground
			instance.processFrontEndFiles();
			//	register header files
			compiler.registerCmhFiles(instance.cmhFiles);
			//	check all files
			var all_valid = true;
			var dataPack = {};
			$.each(instance.cmcFiles, function(index, cmcFile) {
				var response = compiler.check(cmcFile);
				var $badge = $('.file-list-item[data-file-name="' + cmcFile.name + '"]').find('.pending-badge');
				if (response.status === 'accepted') {
					$badge.removeClass('badge-warning').addClass('badge-success');
					//	compile and get JSON
					var extension = GeneralFunctions.getFileExtension(cmcFile.name);
					dataPack[extension] = {
						ext: extension,
						pdf: compiler.Matryona_to_Pdf(),
						list: compiler.Matryona_to_List(),
						graph: compiler.Matryona_to_Graph()
					}
				} else if (response.status === 'rejected') {
					$badge.removeClass('badge-warning').addClass('badge-danger');
					$badge.click(function() {
						alert(response.message);
					});
					all_valid = false;
				}
			});
			if (all_valid) {
				//	ready for upload
				instance.dataPack = dataPack;
			} else {
				GeneralFunctions.displayMessageAlert(SCLang.upload_courschemas_rejected, 'danger', 6000);
			}
		}).trigger('click');
		
		$('#upload-courschema').click(function() {
			instance.uploadCourschemas();
		});
		
	};

	//	Additional Methods
	
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
			var html = '<li class="list-group-item d-flex justify-content-between align-items-center file-list-item" data-file-name="' + name + '"><span class="file-txt"><strong class="file-txt--name">' + name + '</strong> <small class="text-muted file-txt--addi">' + file.size + ' bytes, last modified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a') + '</small></span>' + obj.pendingBtn + '</li>';
			if (extension === 'cmh') {
				output_cmh.push(html);
				obj.cmhFiles.push(file);
			} else if (extension === 'cmc') {
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
        var postUrl = GlobalVariables.baseUrl + '/index.php/course_api/ajax_add_courses_by_excel';
		
		var obj = this;
		
        var files = obj.cmhFiles.concat(obj.cmcFiles);
		
		var postData = new FormData();
		postData.append('csrfToken', GlobalVariables.csrfToken);
		postData.append('target_file[]', files);
		postData.append('dataPack', obj.dataPack);
		
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
				
//				if (response.status === 'success') {
//					GeneralFunctions.displayMessageAlert(SCLang.upload_courses_success, 'success', 6000);
//					obj.refreshTable();
//				} else if (response.status === 'fail') {
//					GeneralFunctions.displayMessageAlert(SCLang.upload_courses_failure, 'danger', 6000);
//				} else {
//					GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
//				}
			},
			error: function(e) {
				console.error(e);
			}
		});
    };
	
    window.CourschemaManagementHelper = CourschemaManagementHelper;
})();
