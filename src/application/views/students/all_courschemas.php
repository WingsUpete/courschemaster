<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/students/students_all_courschemas.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/students/all_courschemas/all_courschemas.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/students/all_courschemas/all_courschemas_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		StudentsAllCourschemas.initialize(true);
    });
</script>

<!-- Main content -->
<div id="students_all_courschemas" class="main-content" style="padding: 20px;">
	<!-- Title -->
	<h1><?= lang('all_courschemas') ?></h1>
	<hr />
	<!-- A Navigation Bar -->
	<div class="bs-stepper" id="bs-stepper-box">
		<!-- steps -->
		<div class="bs-stepper-header" role="tablist">
			<div class="step" data-target="#sel_dep">
				<button type="button" class="step-trigger" role="tab" aria-controls="sel_dep" id="sel_dep-trigger">
					<span class="bs-stepper-circle">1</span>
					<span class="bs-stepper-label"><?= lang('select_department') ?></span>
				</button>
			</div>
			<div class="line"></div>
			<div class="step" data-target="#sel_maj">
				<button type="button" class="step-trigger" role="tab" aria-controls="sel_maj" id="sel_maj-trigger">
					<span class="bs-stepper-circle">2</span>
					<span class="bs-stepper-label"><?= lang('select_major') ?></span>
				</button>
			</div>
			<div class="line"></div>
			<div class="step" data-target="#sel_ver">
				<button type="button" class="step-trigger" role="tab" aria-controls="sel_ver" id="sel_ver-trigger">
					<span class="bs-stepper-circle">3</span>
					<span class="bs-stepper-label"><?= lang('select_version') ?></span>
				</button>
			</div>
		</div>
		<br />
		<!-- Steps Content -->
		<div class="bs-stepper-content">
			<div id="sel_dep" class="content" role="tabpanel" aria-labelledby="sel_dep-trigger">
				<div class="contents">
					<h2>
						<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--prev disabled"><i class="fas fa-chevron-left"></i></i></button>
						<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--next"><i class="fas fa-chevron-right"></i></i></button>
						<?= lang('select_department') ?>
					</h2>
					<hr />
				</div>
			</div>
			<div id="sel_maj" class="content" role="tabpanel" aria-labelledby="sel_maj-trigger">
				<div class="contents">
					<h2>
						<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--prev"><i class="fas fa-chevron-left"></i></i></button>
						<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--next"><i class="fas fa-chevron-right"></i></i></button>
						<?= lang('select_major') ?>
					</h2>
					<hr />
				</div>
			</div>
			<div id="sel_ver" class="content" role="tabpanel" aria-labelledby="sel_ver-trigger">
				<div class="contents">
					<h2>
						<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--prev"><i class="fas fa-chevron-left"></i></i></button>
						<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--next disabled"><i class="fas fa-chevron-right"></i></i></button>
						<?= lang('select_version') ?>
					</h2>
					<hr />
				</div>
			</div>
		</div>
	</div>
</div>