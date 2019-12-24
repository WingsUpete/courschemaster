<script type="text/javascript" src="<?= asset_url('assets/js/students/learned/learned.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/students/learned/learned_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		Learned.initialize(true);
    });
</script>

<!-- Main content -->
<div id="students_learned" class="main-content">
	<h1 class="hide-for-now"><?= lang('learned') ?></h1>
	<hr class="hide-for-now" />
	<!-- Course table -->
	<?php
		$course_table_headers = array(
			lang('course_code'), lang('course_name'), lang('course_total_credit'), lang('course_weekly_period'), lang('course_prerequisite_stat'), lang('course_department')
		);
	?>
	<div class="table-responsive"><table id="courses-datatable" class="table table-bordered table-hover table-condensed text-center">
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
