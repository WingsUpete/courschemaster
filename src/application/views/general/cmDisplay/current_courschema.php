<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/cmDisplay/current_courschema.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/current_courschema/current_courschema.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/current_courschema/current_courschema_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		CurrentCourschema.initialize(true);
    });
</script>

<!-- Main content -->
<div id="students_current_courschema" class="main-content" style="padding: 20px;">
	<h2><?= lang('my_courschema') ?></h2>
	<hr />
	
	<!-- Others -->
	<div id="student_checkspecificcourschema" class="student_checkspecificcourschema">
		<ul class="nav nav-tabs" id="courschema_list" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="General_compulsory-tab" data-toggle="tab" href="#General_compulsory" role="tab" aria-controls="General_compulsory" aria-selected="true">General compulsory</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="Professional_foundation-tab" data-toggle="tab" href="#Professional_foundation" role="tab" aria-controls="Professional_foundation" aria-selected="false">Professional foundation</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="Professional_core-tab" data-toggle="tab" href="#Professional_core" role="tab" aria-controls="Professional_core" aria-selected="false">Professional core</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="Professional_elective-tab" data-toggle="tab" href="#Professional_elective" role="tab" aria-controls="Professional_elective" aria-selected="false">Professional elective</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="General_elective-tab" data-toggle="tab" href="#General_elective" role="tab" aria-controls="General_elective" aria-selected="false">General elective</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="Practice-tab" data-toggle="tab" href="#Practice" role="tab" aria-controls="Practice" aria-selected="false">Practice</a>
			</li>
		</ul>
		
		<table id="datatable" class="table table-striped table-bordered table-hover table-condensed text-center">
			<thead class="alert-primary">
				<tr>
					<th class="th-sm justify-content-center">Course ID</th>
					<th class="th-sm">Course Name</th>
					<th class="th-sm">Period</th>
					<th class="th-sm">Course Credit</th>
					<th class="th-sm">Prerequisite</th>
					<th class="th-sm">Department</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>CS102A</td>
					<td>计算机程序设计基础A</td>
					<td>64</td>
					<td>4</td>
					<td>无</td>
					<td>计算机科学与工程系</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>