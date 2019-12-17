<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/cmManagement/course_management.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/course_management/course_management_helper.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/course_management/course_management.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
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
		<button type="button" class="btn btn-sm add"><i class="fas fa-plus fa-lg"></i></button>
		&ensp;&ensp;
		<div>
		<div class="input-group">
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="choose-file" aria-describedby="upload-file" />
				<label class="custom-file-label" for="choose-file">Choose File</label>
			</div>
			<div class="input-group-append">
				<span class="input-group-text" id="upload-file" data-toggle="tooltip" data-title="Upload" data-placement="right"><i class="fas fa-upload fa-sm"></i></span>
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
			'Course ID', 'Course Name', 'Total_Credit', 'Weekly Period', 'Department'
//			'Semester', 'Language', 'Experimental Credit', 'Advanced Placement', 'Course Description'
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
		<tfoot>
			<tr><?php echo('<td colspan="' . count($course_table_headers) . '" class="text-muted font-weight-bold">Click a course item to modify</td>'); ?></tr>
		</tfoot>
		<tbody></tbody>
	</table></div>
	<!-- courseWindow -->
	<div class="modal fade top" id="courseWindow" tabindex="-1" role="dialog" aria-labelledby="courseWindowLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg side-modal modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="courseWindowLabel">Handle Courses</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="md-form md-outline">
						<input type="text" id="course_code" class="form-control is-invalid" maxlength="50" />
						<label for="course_code" data-error="wrong" data-success="right">Code</label>
						<div class="invalid-feedback"></div>
					</div>
					<div class="md-form md-outline">
						<input type="text" id="course_chinese_name" class="form-control is-invalid" maxlength="150" />
						<label for="course_chinese_name" data-error="wrong" data-success="right">Chinese Name</label>
						<div class="invalid-feedback"></div>
					</div>
					<div class="md-form md-outline">
						<input type="text" id="course_english_name" class="form-control is-invalid" maxlength="150" />
						<label for="course_english_name" data-error="wrong" data-success="right">English Name</label>
						<div class="invalid-feedback"></div>
					</div>
					<div class="md-form md-outline">
						<input type="number" id="course_total_credit" class="form-control is-invalid" maxlength="150" />
						<label for="course_total_credit" data-error="wrong" data-success="right">Total Credit</label>
						<div class="invalid-feedback"></div>
					</div>
					<div class="md-form md-outline">
						<input type="number" id="course_experiment_credit" class="form-control is-invalid" maxlength="150" />
						<label for="course_experiment_credit" data-error="wrong" data-success="right">Experiment Credit</label>
						<div class="invalid-feedback"></div>
					</div>
					<div class="md-form md-outline">
						<input type="number" id="course_weekly_period" class="form-control is-invalid" maxlength="150" />
						<label for="course_weekly_period" data-error="wrong" data-success="right">Weekly Period</label>
						<div class="invalid-feedback"></div>
					</div>
					<div class="md-form md-outline">
						<input type="text" id="course_semester" class="form-control is-invalid" maxlength="150" />
						<label for="course_semester" data-error="wrong" data-success="right">Semester</label>
						<div class="invalid-feedback"></div>
					</div>
					<div class="md-form md-outline">
						<input type="text" id="course_language" class="form-control is-invalid" maxlength="150" />
						<label for="course_language" data-error="wrong" data-success="right">Language</label>
						<div class="invalid-feedback"></div>
					</div>
					<div class="md-form md-outline">
						<textarea id="course_prelogic" class="md-textarea form-control is-invalid" rows="5" maxlength="250" style="resize:none;"></textarea>
						<label for="course_prelogic" data-error="wrong" data-success="right">Pre-logic</label>
						<div class="invalid-feedback"></div>
					</div>
					<div class="md-form md-outline">
						<textarea id="course_description" class="md-textarea form-control is-invalid" rows="5" maxlength="250" style="resize:none;"></textarea>
						<label for="course_description" data-error="wrong" data-success="right">Description</label>
						<div class="invalid-feedback"></div>
					</div>
					<div class="md-form md-outline">
						<textarea id="course_english_description" class="md-textarea form-control is-invalid" rows="5" maxlength="250" style="resize:none;"></textarea>
						<label for="course_english_description" data-error="wrong" data-success="right">English Description</label>
						<div class="invalid-feedback"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="add-course-submit" type="button" class="btn btn-primary btn-sm"><?= lang('submit') ?></button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= lang('close') ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
