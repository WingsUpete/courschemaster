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
<div id="current_courschema" class="main-content">
	<h1><?= lang('my_courschema') ?></h1>
	<hr />
	<!-- Views -->
	<?php
		// Array for couschema view icons (alias, active, icon, lang)
		$cc_views = array(
			array('pdf', 'true', 'file-pdf', lang('pdf')),
			array('list', 'false', 'list', lang('list')),
			array('graph', 'false', 'sitemap', lang('graph'))
		);
	?>
	<ul class="nav nav-pills pills-pink mb-3" id="cc-views" role="tablist">
		<?php
			for ($i = 0; $i < count($cc_views); $i++) {
				echo('<li class="nav-item">');
				echo('<a class="nav-link font-weight-bold' . ($cc_views[$i][1] == 'true' ? ' active' : '') . '" id="cc-views-' . $cc_views[$i][0] . '" data-toggle="pill" title="' . $cc_views[$i][3] . '" href="#cc-views-' . $cc_views[$i][0] . '-content" role="tab" aria-controls="cc-views-' . $cc_views[$i][0] . '-content" aria-selected="' . $cc_views[$i][1] . '">');
				echo('<i class="fas fa-' . $cc_views[$i][2] . ' fa-lg"></i><span class="cc-views-txt">&ensp;' . $cc_views[$i][3] . '</span>');
				echo('</a></li>');
			}
		?>
	</ul>
	<div class="tab-content" id="cc-views-content">
		<div class="tab-pane fade show active" id="cc-views-pdf-content" role="tabpanel" aria-labelledby="cc-views-pdf">
			<iframe id="cc-pdf-window" title="Courschema PDF" width="100%" height="666px" src=""></iframe>
			<div id="cc-pdf-download-block" class="text-right">
				<button id="cc-pdf-download" type="button" class="btn btn-primary font-weight-bold mr-0">
					<a href="javascript:void(0);" target="_blank">
						<i class="fas fa-download"></i>
						&nbsp;
						<?= lang('download') ?>
					</a>
				</button>
			</div>
		</div>
		<div class="tab-pane fade" id="cc-views-list-content" role="tabpanel" aria-labelledby="cc-views-list">
			<div class="card text-center">
				<div class="card-header">
					<ul class="nav nav-tabs card-header-tabs">
						<li class="nav-item">
							<a class="nav-link active" href="#">Active</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Link</a>
						</li>
						<li class="nav-item">
							<a class="nav-link disabled" href="#">Disabled</a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<h5 class="card-title">Special title treatment</h5>
					<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
					<a href="#" class="btn btn-primary">Go somewhere</a>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="cc-views-graph-content" role="tabpanel" aria-labelledby="cc-views-graph">
			GRAPH
		</div>
	</div>
	
	
	
	
	
<!--
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
-->
</div>