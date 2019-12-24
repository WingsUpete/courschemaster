<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/cmManagement/student_info.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/student_info/student_info.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/student_info/student_info_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		StudentInfo.initialize(true);
    });
</script>

<!-- Main content -->
<div id="student_info" class="main-content">
	<h1 class="hide-for-now">Student Info</h1>
	<hr class="hide-for-now" />
	<!-- student info table -->
	<?php
		$course_table_headers = array(
			lang('sid'), lang('student_name'), lang('department'), lang('major'), lang('courschema_name'), lang('operation')
		);
	?>
	<div class="table-responsive"><table id="students_info-datatable" class="table table-bordered table-hover table-condensed text-center">
		<thead>
			<tr>
				<?php
					for ($i = 0; $i < count($course_table_headers); $i++) {
						echo('<th class="th-sm justify-content-center">' . $course_table_headers[$i] . '</th>');
					}
				?>
			</tr>
		</thead>
		<tbody></tbody>
	</table></div>
</div>
