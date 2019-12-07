<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/cmDisplay/collection.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/collection/collection.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/collection/collection_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		Collection.initialize(true);
    });
</script>

<!-- Main content -->
<div id="collection" class="main-content">
	<h1><?= lang('collection') ?></h1>
	<hr />
	<!-- Course Table -->
	<?php
		$course_filters = array(
			'General compulsory', 'Professional foundation', 'Professional core',
			'Professional elective', 'General elective', 'Practice'
		);
		$course_table_headers = array(
			'Course ID', 'Course Name', 'Total_Credit', 'Weekly Period', 'Department',
//			'Semester', 'Language', 'Experimental Credit', 'Advanced Placement', 'Course Description'
		);
	?>
	<div class="table-responsive"><table id="courses-datatable" class="table table-striped table-bordered table-hover table-condensed text-center">
		<thead>
			<tr>
				<?php
				for ($i = 0; $i < count($course_table_headers); $i++) {
					echo('<th class="th-sm justify-content-center">' . $course_table_headers[$i] . '</th>');
				}
			?>
			</tr>
		</thead>
		<tfoot>
			<tr><?php echo('<td colspan="' . count($course_table_headers) . '" class="text-muted">Footer Information</td>'); ?></tr>
		</tfoot>
		<tbody></tbody>
	</table></div>
</div>
