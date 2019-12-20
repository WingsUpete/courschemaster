<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/cmManagement/course_management.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/course_management/course_management_helper.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/course_management/course_management.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>,
		language           : '<?= $this->config->item('language') ?>'
		//	course_info, find it elsewhere
    };

    $(document).ready(function() {
		CourseManagement.initialize(true);
    });
</script>

<!-- Main content -->
<div id="course_management" class="main-content">
	<h1 class="hide-for-now">Course Management</h1>
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
	<?php
		$course_filters = array(
			'General compulsory', 'Professional foundation', 'Professional core',
			'Professional elective', 'General elective', 'Practice'
		);
		$course_table_headers = array(
			lang('course_code'), lang('course_name'), lang('course_total_credit'), lang('course_weekly_period'), lang('course_department'),
			lang('course_semester'), lang('course_language'), lang('course_experiment_credit'), lang('course_prelogic'), lang('course_description')
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
	<!-- courseWindow -->
	<div class="modal fade top" id="courseWindow" tabindex="-1" role="dialog" aria-labelledby="courseWindowLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg side-modal modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="courseWindowLabel"><?= lang('details') ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php
						// id, input / textarea, input type / textarea rows, display / optional
						$course_info = array(
							array('course_code', 'input', 'text', lang('course_code'), '1'),
							array('course_chinese_name', 'input', 'text', lang('course_chinese_name'), '1'),
							array('course_english_name', 'input', 'text', lang('course_english_name'), '1'),
							array('course_department', 'input', 'text', lang('course_department'), '1'),
							array('course_total_credit', 'input', 'number', lang('course_total_credit'), '0'),
							array('course_experiment_credit', 'input', 'number', lang('course_experiment_credit'), '0'),
							array('course_weekly_period', 'input', 'number', lang('course_weekly_period'), '0'),
							array('course_semester', 'input', 'text', lang('course_semester'), '0'),
							array('course_language', 'input', 'text', lang('course_language'), '0'),
							array('course_prelogic', 'textarea', '2', lang('course_prelogic'), '0'),
							array('course_description', 'textarea', '5', lang('course_cn_description'), '0'),
							array('course_english_description', 'textarea', '5', lang('course_english_description'), '0'),
						);
					?>
					<script>
						GlobalVariables.course_info = <?= json_encode($course_info) ?>;
					</script>
					<?php
						for ($i = 0; $i < count($course_info); $i++) {
							$course = $course_info[$i];
							echo('<div class="md-form md-outline">');
							if ($course[1] == 'input') {
								echo('<input type="' . $course[2] . '" id="' . $course[0] . '" class="form-control is-invalid" />');
							} else if ($course[1] == 'textarea') {
								echo('<textarea id="' . $course[0] . '" class="md-textarea form-control is-invalid" rows="' . $course[2] . '" style="resize:none;"></textarea>');
							}
							echo('<label for="' . $course[0] . '" data-error="wrong" data-success="right">' . $course[3] . '</label>');
							echo('<div class="invalid-feedback"></div></div>');
						}
					?>
				</div>
				<div class="modal-footer">
					<button id="delete-course" type="button" class="btn btn-danger btn-sm"><?= lang('delete') ?></button>
					<button id="add-course-submit" type="button" class="btn btn-primary btn-sm"><?= lang('submit') ?></button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= lang('close') ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
