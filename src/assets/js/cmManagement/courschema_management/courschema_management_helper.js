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
		$('.submit-files').click(function() {
			var compiler = instance.compiler;
			//	process files in frontend ground
			instance.processFrontEndFiles();
			//	register header files
			var res_msg = compiler.registerCmhFiles(instance.cmhFiles);
//			var cmhOK = true;
			$.each(res_msg, function(index, msg) {
				var $badge = $('.file-list-item[data-file-name="' + msg.name + '"]').find('.pending-badge');
				if (msg.status === 'accepted') {
					$badge.removeClass('badge-warning').addClass('badge-success');
					$badge.html(SCLang.accepted);
				} else if (msg.status === 'rejected') {
					$badge.removeClass('badge-warning').addClass('badge-danger');
					$badge.html(SCLang.rejected);
					$badge.click(function() {
						GeneralFunctions.displayMessageAlert(msg.message, 'danger', 6000);
					});
//					cmhOK = false;
				}
			});
//			if (!cmhOK) {
//				instance.abortChecking();
//				return;
//			}

			//	check all files
			var dataPack = {};
			for (var i = 0; i < instance.cmcFiles.length; ++i) {
				var cmcFile = instance.cmcFiles[i];
				var promiseCompile = function(cmc) {
					return new Promise(function(resolve, reject) {
						var res = compiler.check(cmc);
						alert('check');
						resolve(res);
					});
				};
				$.when(promiseCompile(cmcFile)).then(function(response) {
					alert(response);
					var $badge = $('.file-list-item[data-file-name="' + cmcFile.name + '"]').find('.pending-badge');
					if (response.status === 'accepted') {
						$badge.removeClass('badge-warning').addClass('badge-success');
						$badge.html(SCLang.accepted);
						//	compile and get JSON
						var extension = GeneralFunctions.getFileExtension(cmcFile.name);
						dataPack[extension] = {
							maj: $('#upload-major option:selected').val(),
							ext: extension,
							pdf: compiler.Matryona_to_Pdf(),
							list: compiler.Matryona_to_List(),
							graph: compiler.Matryona_to_Graph()
						};
					} else if (response.status === 'rejected') {
						$badge.removeClass('badge-warning').addClass('badge-danger');
						$badge.html(SCLang.rejected);
						$badge.click(function() {
							GeneralFunctions.displayMessageAlert(response.message, 'danger', 6000);
						});
						instance.abortChecking();
						return;
					}
				});
			}
			//	ready for upload
			$('#upload-courschema').prop('disabled', 'false');
			instance.dataPack = dataPack;
		}).trigger('click');
		
		$('#upload-courschema').click(function() {
			instance.uploadCourschemas();
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
				html = '<li class="list-group-item d-flex justify-content-between align-items-center file-list-item cmh-item" data-file-name="' + name + '"><span class="file-txt"><strong class="file-txt--name">' + name + '</strong> <small class="text-muted file-txt--addi">' + file.size + ' bytes, last modified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a') + '</small></span class="hide-for-now">' + obj.pendingBtn + '</li>';
				output_cmh.push(html);
				obj.cmhFiles.push(file);
			} else if (extension === 'cmc') {
				html = '<li class="list-group-item d-flex justify-content-between align-items-center file-list-item cmc-item" data-file-name="' + name + '"><span class="file-txt"><strong class="file-txt--name">' + name + '</strong> <small class="text-muted file-txt--addi">' + file.size + ' bytes, last modified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a') + '</small></span class="hide-for-now">' + obj.pendingBtn + '</li>';
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
		
		var postData = new FormData();
		postData.append('csrfToken', GlobalVariables.csrfToken);
		for (var i = 0; i < files.length; ++i) {
			postData.append('target_file[]', files[i]);
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
				
//				if (response.status === 'success') {
//					GeneralFunctions.displayMessageAlert(SCLang.upload_courses_success, 'success', 6000);
//					$('#upload-cmh-list').html('');
//					$('#upload-cmc-list').html('');
//					$('#upload-courschema').prop('disabled', 'true');
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
			
			$('#upload-major').html('');
			$.each(response, function(index, major) {
				$('#upload-major').append('<option value="' + major.id + '">' + major.name + '</option>');
			});
			
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };
	
    window.CourschemaManagementHelper = CourschemaManagementHelper;
})();
