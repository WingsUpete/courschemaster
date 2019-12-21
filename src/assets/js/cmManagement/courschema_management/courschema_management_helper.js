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
		this.pendingBtn = '<span class="badge badge-warning badge-pill">' + SCLang.checking + '</span>';
		this.cmcFiles = [];		
		this.cmhFiles = [];		
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
			var files = $('#choose-files').prop('files');	// FileList obj
			var output_cmh = [];
			var output_cmc = [];
			instance.cmhFiles = [];
			instance.cmcFiles = [];
			$.each(files, function(index, file) {
				var name = file.name;
				var extension = name.substring(name.lastIndexOf('.')+1);
				var html = '<li class="list-group-item d-flex justify-content-between align-items-center file-list-item"><span class="file-txt"><strong class="file-txt--name">' + name + '</strong> <small class="text-muted file-txt--addi">' + file.size + ' bytes, last modified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a') + '</small></span>' + instance.pendingBtn + '</li>';
				if (extension === 'cmh') {
					output_cmh.push(html);
					instance.cmhFiles.push(file);
				} else if (extension === 'cmc') {
					output_cmc.push(html);
					instance.cmcFiles.push(file);
				}
			});
			var emptyHTML = '<small class="text-muted ml-2">' + SCLang.no_record + '</small>';
			$('#upload-cmh-list').html(output_cmh.length === 0 ? emptyHTML : output_cmh.join(''));
			$('#upload-cmc-list').html(output_cmc.length === 0 ? emptyHTML : output_cmc.join(''));
		}).trigger('click');
		
	};

	//	Additional Methods
	
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
	
    window.CourschemaManagementHelper = CourschemaManagementHelper;
})();
