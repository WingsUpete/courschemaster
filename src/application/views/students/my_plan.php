<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/students/my_plan.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/students/my_plan/my_plan.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/students/my_plan/my_plan_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>,
		language           : '<?= $this->config->item('language') ?>'
    };

    $(document).ready(function() {
		MyPlan.initialize(true);
    });
</script>

<!-- Main content -->
<div id="my_plan" class="main-content">
	<h1 class="hide-for-now"><?= lang('my_plan') ?></h1>
	<hr class="hide-for-now" />
	<div class="alert alert-info alert-dismissible fade show tutorial" role="alert">
		<?= lang('my_plan_tutorial') ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	  		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<!-- Table -->
	<div class="container-fluid w-100 px-0">
		<div class="row">
			<!-- col-xs-12 col-lg-6 -->
			<div class="col-xl-12">
				<div class="card plan-window mb-3">
					<div class="card-header">
						<ul class="nav nav-tabs card-header-tabs" id="my-plan-panel" role="tablist">
							<span class="plan-titles"></span>
							<li class="nav-item">
								<a class="nav-link font-weight-bold active" id="mp_test" data-toggle="tab" title="Test" href="javascript:void(0);" role="tab" aria-selected="true">Test</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="add_plan" title="<?= lang('add_plan') ?>" href="javascript:void(0);" role="tab" aria-selected="false" data-toggle="modal" data-target="#newPlanWindow"><i class="fas fa-plus font-weight-bold"></i>&ensp;<small class="text-muted"><span class="plan_count">3</span>/5</small></a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="my-plan-panel-content">
							<button type="button" class="btn tool-btn btn-sm mb-2" data-toggle="modal" data-target="#courseMarket">
								<i class="fas fa-shopping-cart"></i>
								&ensp;
								<?= lang('add') ?>
							</button>
							<?php
								$course_table_headers = array(
									lang('course_code'), lang('course_name'), lang('course_learned_date'), lang('course_label'), lang('operation')
								);
							?>
							<div class="table-responsive"><table id="plan-courses-datatable" class="table table-bordered table-hover table-condensed text-center">
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
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-lg-6 hide-for-now">
				<div class="card border-light mb-3 graph-window">
					<div class="card-header"><?= lang('graph') ?></div>
					<div class="card-body">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- courseMarket -->
<div class="modal fade top" id="courseMarket" tabindex="-1" role="dialog" aria-labelledby="courseMarketLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg side-modal modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="courseMarketLabel"><?= lang('add') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="md-form md-outline mb-3">
					<i class="fas fa-search fa-4x prefix"></i>
					<input type="text" id="qa-search" class="form-control">
					<label for="qa-search"><?= lang('search') ?></label>
				</div>
				<?php
					$course_table_headers = array(
						lang('course_code'), lang('course_name'), lang('course_total_credit'), lang('course_department')
					);
				?>
				<div class="table-responsive"><table id="market-courses-datatable" class="table table-bordered table-hover table-condensed text-center">
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
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= lang('close') ?></button>
			</div>
		</div>
	</div>
</div>
<!-- newPlan -->
<div class="modal fade top" id="newPlanWindow" tabindex="-1" role="dialog" aria-labelledby="newPlanWindowLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm side-modal modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newPlanWindowLabel"><?= lang('add_plan') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="md-form md-outline">
					<input type="text" id="new_plan_name" max="100" class="form-control is-invalid">
					<label for="new_plan_name" data-error="wrong" data-success="right"><?= lang('name') ?></label>
					<div class="invalid-feedback"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="new_plan-submit" type="button" class="btn btn-primary btn-sm"><?= lang('submit') ?></button>
				<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= lang('close') ?></button>
			</div>
		</div>
	</div>
</div>