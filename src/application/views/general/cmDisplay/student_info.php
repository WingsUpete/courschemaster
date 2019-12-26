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
			'student_id', 
			lang('sid'), lang('student_name'), lang('department'), lang('major'), lang('courschema_name'), lang('operation'),
			'courschema_id'
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

<!-- assignWindow -->
<div class="modal fade top" id="assignWindow" tabindex="-1" role="dialog" aria-labelledby="assignWindowLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl side-modal modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="assignWindowLabel"><?= lang('assign') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="assign_student_id" />
				<?php
					$courschema_headers = array(
						'courschema_id', 
						lang('courschema_name'), lang('department'), lang('major')
					);
				?>
				<div class="table-responsive"><table id="assign_courschema-datatable" class="table table-bordered table-hover table-condensed text-center">
					<thead>
						<tr>
							<?php
								for ($i = 0; $i < count($courschema_headers); $i++) {
									echo('<th class="th-sm justify-content-center">' . $courschema_headers[$i] . '</th>');
								}
							?>
						</tr>
					</thead>
					<tbody></tbody>
				</table></div>
			</div>
		</div>
	</div>
</div>
