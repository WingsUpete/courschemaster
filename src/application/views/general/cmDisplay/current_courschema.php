<?php
	if($template_status == lang('visitor')) {
		echo('<link rel="stylesheet" type="text/css" href="' . asset_url('assets/css/visitors/visitors.css', NULL, 'css') . '" />');
	}
?>
<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/cmDisplay/current_courschema.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/current_courschema/current_courschema.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/current_courschema/current_courschema_helper.js', NULL, 'js') ?>"></script>
<script>
	if ('<?= $template_status ?>' === SCLang.my_courschema) {
    	var GlobalVariables = {
    	    csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
			baseUrl            : <?= json_encode($base_url) ?>,
			templateStatus     : '<?= $template_status ?>',
		    loggedIn           : <?= $logged_in ?>,
			retrieveIdFirst    : true,
			courschemaId       : '',
			courschemaName     : '',
			collected          : -1
    	};
	}

    $(document).ready(function() {
		CurrentCourschema.initialize(true);
    });
</script>

<!-- Main content -->
<div id="current_courschema" class="main-content">
	<h1 class="hide-for-now"><?= $template_status ?></h1>
	<hr class="hide-for-now" />
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
		<?php $display_collect = ($logged_in) ? 'hide-for-certain-role' : ''; ?>
		<li class="nav-item <?= $display_collect ?>">
			<a class="nav-link font-weight-bold collect">
				<i class="far fa-star fa-lg text-warning"></i>
			</a>
		</li>
	</ul>
	<div class="tab-content" id="cc-views-content">
		<div class="tab-pane fade show active" id="cc-views-pdf-content" role="tabpanel" aria-labelledby="cc-views-pdf">
			<iframe id="cc-pdf-window" title="Courschema PDF"></iframe>
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
			<div class="card">
				<div class="card-header">
					<ul class="nav nav-tabs card-header-tabs" id="list-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link font-weight-bold active" id="list-tabs-events" data-toggle="tab" title="Events" href="#list-tabs-events-content" role="tab" aria-controls="list-tabs-events-content" aria-selected="true"><?= lang('events') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link font-weight-bold" id="list-tabs-courses" data-toggle="tab" title="Courses" href="#list-tabs-courses-content" role="tab" aria-controls="list-tabs-courses-content" aria-selected="false"><?= lang('courses') ?></a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content" id="list-tabs-content">
						<div class="tab-pane fade show active" id="list-tabs-events-content" role="tabpanel" aria-labelledby="list-tabs-events">
							<h5 class="card-title"><?= lang('events') ?></h5>
							<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
							<a href="#" class="btn btn-primary">Go somewhere</a>
						</div>
						<div class="tab-pane fade" id="list-tabs-courses-content" role="tabpanel" aria-labelledby="list-tabs-courses">
							<?php
								$course_filters = array(
									'General compulsory', 'Professional foundation', 'Professional core',
									'Professional elective', 'General elective', 'Practice'
								);
								$course_table_headers = array(
									'Course ID', 'Course Name', 'Total_Credit', 'Weekly Period', 'Department',
//									'Semester', 'Language', 'Experimental Credit', 'Advanced Placement', 'Course Description'
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
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="cc-views-graph-content" role="tabpanel" aria-labelledby="cc-views-graph">
			GRAPH
		</div>
	</div>
</div>