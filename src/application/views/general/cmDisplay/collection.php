<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/cmDisplay/collection.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/collection/collection.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/collection/collection_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>,
		end                : '<?= $end ?>'
    };

    $(document).ready(function() {
		Collection.initialize(true);
    });
</script>

<!-- Main content -->
<div id="collection" class="main-content">
	<h1 class="hide-for-now"><?= lang('collection') ?></h1>
	<hr class="hide-for-now" />
	<div class="alert alert-info alert-dismissible fade show tutorial" role="alert">
		<?= lang('collection_tutorial') ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	  		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<!-- Collection Table -->
	<?php
		$courschema_table_headers = array(
			lang('courschema_id'), lang('courschema_name'), lang('courschema_major'), lang('courschema_department'),
			lang('operation')
		);
	?>
	<div class="table-responsive"><table id="courschemas-datatable" class="table table-bordered table-hover table-condensed text-center">
		<thead>
			<tr>
				<?php
					for ($i = 0; $i < count($courschema_table_headers); $i++) {
						echo('<th class="th-sm justify-content-center">' . $courschema_table_headers[$i] . '</th>');
					}
				?>
			</tr>
		</thead>
		<tbody></tbody>
	</table></div>
</div>
