<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/cmManagement/courschema_management.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/courschema_management/courschema_management_helper.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/courschema_management/courschema_management.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		CourschemaManagement.initialize(true);
    });
</script>

<!-- Main content -->
<div id="courschema_management" class="main-content">
	<h1 class="hide-for-now">Courschema Management</h1>
	<hr class="hide-for-now" />
	<!-- Button group -->
	<div class="row pl-3 pr-3 mb-4">
		<button type="button" class="btn btn-sm add" data-toggle="tooltip" data-title="<?= lang('add') ?>"><i class="fas fa-plus fa-lg"></i></button>
		&ensp;&ensp;
		<div>
		<div class="input-group">
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="choose-file" aria-describedby="upload-file" />
				<label class="custom-file-label" for="choose-file"><?= lang('choose_file') ?></label>
			</div>
			<div class="input-group-append">
				<span class="input-group-text" id="upload-file" data-toggle="tooltip" data-title="<?= lang('upload') ?>" data-placement="right"><i class="fas fa-upload fa-sm"></i></span>
			</div>
		</div>
		</div>
	</div>
</div>
